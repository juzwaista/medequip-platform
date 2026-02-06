<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartItems = $this->enrichCartItems($cart);
        $subtotal = $this->calculateSubtotal($cartItems);

        return Inertia::render('Checkout/Index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'cities' => config('cavite.cities'),
            'barangays' => config('cavite.barangays'),
            'savedAddresses' => auth()->user()->addresses()->latest()->get(),
        ]);
    }

    /**
     * Place order
     */
    public function placeOrder(Request $request)
    {
        \Log::info('Order placement started', [
            'user_id' => auth()->id(),
            'request_data' => $request->all()
        ]);

        // Validate OUTSIDE try-catch so validation exceptions propagate to Inertia
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|min:2|max:100',
                'delivery_address' => 'required|string|max:500|min:5',
                'contact_number' => 'required|string|min:7|max:20',
                'notes' => 'nullable|string|max:1000',
            ], [
                'customer_name.required' => 'Please provide the recipient name',
                'customer_name.min' => 'Name must be at least 2 characters.',
                'delivery_address.required' => 'Please provide a delivery address',
                'delivery_address.min' => 'Delivery address must be at least 5 characters.',
                'contact_number.required' => 'Contact number is required for delivery',
                'contact_number.min' => 'Contact number must be at least 7 digits',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation failed', ['errors' => $e->errors()]);
            throw $e; // Re-throw for Inertia to handle
        }

        \Log::info('Validation passed', ['validated' => $validated]);

        $cart = session()->get('cart', []);

        \Log::info('Cart retrieved', ['cart_count' => count($cart)]);

        if (empty($cart)) {
            \Log::warning('Cart is empty');
            return back()->withErrors(['cart' => 'Your cart is empty'])->withInput();
        }

        try {
            DB::beginTransaction();
            \Log::info('Transaction started');

            // Group cart items by distributor
            $ordersByDistributor = [];

            foreach ($cart as $productId => $cartItem) {
                \Log::info('Processing cart item', ['product_id' => $productId, 'quantity' => $cartItem['quantity']]);

                $product = Product::with('inventory')->findOrFail($productId);

                \Log::info('Product loaded', [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'inventory_count' => $product->inventory->count()
                ]);

                $distributorId = $product->distributor_id;

                if (!isset($ordersByDistributor[$distributorId])) {
                    $ordersByDistributor[$distributorId] = [
                        'distributor_id' => $distributorId,
                        'items' => []
                    ];
                }

                $ordersByDistributor[$distributorId]['items'][] = [
                    'product' => $product,
                    'quantity' => $cartItem['quantity'],
                ];
            }

            \Log::info('Orders grouped by distributor', ['distributor_count' => count($ordersByDistributor)]);

            // Create separate order for each distributor
            $createdOrders = [];

            foreach ($ordersByDistributor as $distributorData) {
                \Log::info('Creating order for distributor', ['distributor_id' => $distributorData['distributor_id']]);

                $order = Order::create([
                    'customer_id' => auth()->id(),
                    'distributor_id' => $distributorData['distributor_id'],
                    'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                    'status' => 'pending',
                    'subtotal' => 0,
                    'total_amount' => 0, // Will calculate
                    'delivery_address' => $validated['delivery_address'],
                    'contact_number' => $validated['contact_number'],
                    'notes' => $validated['notes'] ?? null,
                ]);

                \Log::info('Order created', ['order_id' => $order->id, 'order_number' => $order->order_number]);

                $totalAmount = 0;

                // Create order items and reserve inventory
                foreach ($distributorData['items'] as $item) {
                    $product = $item['product'];
                    $quantity = $item['quantity'];

                    // Determine price (wholesale if applicable)
                    $isWholesale = $product->wholesale_price && $product->wholesale_min_qty && $quantity >= $product->wholesale_min_qty;
                    $unitPrice = $isWholesale ? $product->wholesale_price : $product->base_price;

                    // Reserve inventory from first available branch
                    $inventory = $product->inventory()
                        ->whereRaw('(quantity - reserved_quantity) >= ?', [$quantity])
                        ->first();

                    if (!$inventory) {
                        throw new \Exception("Insufficient stock for {$product->name}");
                    }

                    // Use the reserve method from Inventory model
                    if (!$inventory->reserve($quantity)) {
                        throw new \Exception("Unable to reserve stock for {$product->name}");
                    }

                    // Create order item with all required fields
                    $order->items()->create([
                        'product_id' => $product->id,
                        'inventory_id' => $inventory->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $unitPrice * $quantity,
                        'is_wholesale' => $isWholesale,
                    ]);


                    $totalAmount += $unitPrice * $quantity;
                }

                // Update order totals
                $order->update([
                    'subtotal' => $totalAmount,
                    'total_amount' => $totalAmount,
                ]);

                // Create invoice (match actual schema)
                Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                    'subtotal' => $totalAmount,
                    'tax' => 0,
                    'discount' => 0,
                    'total_amount' => $totalAmount,
                    'status' => 'unpaid',
                    'due_date' => now()->addDays(7),
                ]);

                \Log::info('Invoice created', ['order_id' => $order->id]);

                $createdOrders[] = $order;
            }

            // Clear cart
            session()->forget('cart');
            \Log::info('Cart cleared');

            DB::commit();
            \Log::info('Transaction committed', ['orders_created' => count($createdOrders)]);

            // Redirect to first order confirmation
            if (count($createdOrders) === 1) {
                \Log::info('Redirecting to confirmation', ['order_id' => $createdOrders[0]->id]);
                return redirect()->route('orders.confirmation', ['order' => $createdOrders[0]->id])
                    ->with('success', 'Order placed successfully!');
            } else {
                \Log::info('Multiple orders created, redirecting to order list');
                return redirect()->route('orders.index')
                    ->with('success', count($createdOrders) . ' orders placed successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Order placement failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withErrors(['order' => 'Failed to place order: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Order confirmation page
     */
    public function confirmation(Order $order)
    {
        // Ensure user owns this order
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'distributor', 'invoice']);

        return Inertia::render('Orders/Confirmation', [
            'order' => $order,
        ]);
    }

    /**
     * My orders page
     */
    public function myOrders()
    {
        $orders = Order::with(['items.product', 'distributor', 'invoice'])
            ->where('customer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Order detail page
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.images', 'distributor', 'invoice.payments', 'delivery']);

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Enrich cart items with product data
     */
    private function enrichCartItems($cart)
    {
        $items = [];

        foreach ($cart as $productId => $cartItem) {
            $product = Product::with(['distributor', 'images', 'inventory'])
                ->find($productId);

            if (!$product) {
                continue;
            }

            $quantity = $cartItem['quantity'];
            $isWholesale = $product->hasWholesalePricing() && $quantity >= $product->wholesale_min_qty;
            $unitPrice = $isWholesale ? $product->wholesale_price : $product->base_price;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'is_wholesale' => $isWholesale,
                'subtotal' => $unitPrice * $quantity,
            ];
        }

        return $items;
    }

    /**
     * Calculate cart subtotal
     */
    private function calculateSubtotal($cartItems)
    {
        return array_sum(array_column($cartItems, 'subtotal'));
    }
}

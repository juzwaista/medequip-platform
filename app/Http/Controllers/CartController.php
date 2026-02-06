<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Get cart from session
     */
    private function getCart()
    {
        return session()->get('cart', []);
    }

    /**
     * Save cart to session
     */
    private function saveCart($cart)
    {
        session()->put('cart', $cart);
    }

    /**
     * Show cart page
     */
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = $this->enrichCartItems($cart);

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'subtotal' => $this->calculateSubtotal($cartItems),
        ]);
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with('inventory')->findOrFail($request->product_id);

        // Check stock availability
        $availableStock = $product->inventory->sum(function ($inv) {
            return $inv->quantity - $inv->reserved_quantity;
        });

        if ($request->quantity > $availableStock) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cart = $this->getCart();

        // If product already in cart, update quantity
        if (isset($cart[$request->product_id])) {
            $newQuantity = $cart[$request->product_id]['quantity'] + $request->quantity;

            if ($newQuantity > $availableStock) {
                return back()->with('error', 'Cannot add more items - insufficient stock');
            }

            $cart[$request->product_id]['quantity'] = $newQuantity;
        } else {
            // Add new item to cart
            $cart[$request->product_id] = [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ];
        }

        $this->saveCart($cart);

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with('inventory')->findOrFail($productId);

        $availableStock = $product->inventory->sum(function ($inv) {
            return $inv->quantity - $inv->reserved_quantity;
        });

        if ($request->quantity > $availableStock) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            $this->saveCart($cart);
        }

        return back()->with('success', 'Cart updated');
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
        }

        return back()->with('success', 'Item removed from cart');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared');
    }

    /**
     * Get cart count (for header badge)
     */
    public function count()
    {
        $cart = $this->getCart();
        $uniqueItems = count($cart); // Count unique items, not total quantity

        return response()->json(['count' => $uniqueItems]);
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

            // Calculate price (wholesale if applicable)
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

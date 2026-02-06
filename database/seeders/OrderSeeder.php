<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Delivery;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        // Create 20 sample orders with various statuses
        foreach (range(1, 20) as $index) {
            $customer = $customers->random();

            // Select 1-4 random products from same distributor
            $orderProducts = $products->groupBy('distributor_id')->random()->take(rand(1, 4));

            if ($orderProducts->isEmpty()) {
                continue;
            }

            $distributor = $orderProducts->first()->distributor;

            $subtotal = 0;
            $orderItemsData = [];

            foreach ($orderProducts as $product) {
                // Get available inventory
                $inventory = $product->inventory()->where('quantity', '>', 0)->first();

                if (!$inventory) {
                    continue;
                }

                $quantity = rand(1, 10);

                // Check wholesale pricing
                $isWholesale = $product->hasWholesalePricing() && $quantity >= $product->wholesale_min_qty;
                $unitPrice = $isWholesale ? $product->wholesale_price : $product->base_price;
                $totalPrice = $unitPrice * $quantity;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'inventory_id' => $inventory->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'is_wholesale' => $isWholesale,
                ];

                $subtotal += $totalPrice;
            }

            if (empty($orderItemsData)) {
                continue;
            }

            // Create order with realistic status distribution
            $statusDistribution = [
                'delivered' => 40, // 40% delivered
                'shipped' => 15,   // 15% in transit
                'packed' => 10,    // 10% packed
                'approved' => 15,  // 15% approved
                'pending' => 20,   // 20% pending
            ];

            $status = $this->getWeightedRandomStatus($statusDistribution);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'distributor_id' => $distributor->id,
                'status' => $status,
                'subtotal' => $subtotal,
                'discount' => 0,
                'total_amount' => $subtotal,
                'delivery_address' => $this->generateAddress(),
                'notes' => rand(1, 3) == 1 ? 'Please deliver during business hours' : null,
                'approved_at' => in_array($status, ['approved', 'processing', 'packed', 'shipped', 'delivered'])
                    ? Carbon::now()->subDays(rand(1, 10))
                    : null,
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);

            // Create order items
            foreach ($orderItemsData as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);

                // Reserve or deduct inventory based on status
                $inventory = Inventory::find($itemData['inventory_id']);
                if (in_array($status, ['approved', 'processing', 'packed', 'shipped', 'delivered'])) {
                    $inventory->deduct($itemData['quantity']);
                } elseif ($status === 'pending') {
                    $inventory->reserve($itemData['quantity']);
                }
            }

            // Create invoice for approved+ orders
            if (in_array($status, ['approved', 'processing', 'packed', 'shipped', 'delivered'])) {
                $invoice = Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => Invoice::generateInvoiceNumber(),
                    'subtotal' => $subtotal,
                    'tax' => 0,
                    'discount' => 0,
                    'total_amount' => $subtotal,
                    'status' => $status === 'delivered' ? 'paid' : (rand(1, 3) == 1 ? 'partial' : 'unpaid'),
                    'due_date' => Carbon::now()->addDays(7),
                ]);

                // Create payment for paid invoices
                if ($invoice->status === 'paid') {
                    Payment::create([
                        'invoice_id' => $invoice->id,
                        'payment_method' => ['cash', 'bank_transfer', 'gcash', 'paymaya'][rand(0, 3)],
                        'amount' => $subtotal,
                        'reference_number' => 'REF-' . strtoupper(substr(md5(rand()), 0, 10)),
                        'status' => 'verified',
                        'verified_at' => Carbon::now()->subDays(rand(1, 5)),
                    ]);
                }
            }

            // Create delivery for packed+ orders
            if (in_array($status, ['packed', 'shipped', 'delivered'])) {
                Delivery::create([
                    'order_id' => $order->id,
                    'tracking_number' => Delivery::generateTrackingNumber(),
                    'delivery_address' => $order->delivery_address,
                    'scheduled_date' => Carbon::now()->addDays(rand(1, 3)),
                    'actual_delivery_at' => $status === 'delivered' ? Carbon::now()->subDays(rand(1, 5)) : null,
                    'driver_name' => $status !== 'pending' ? 'Driver ' . rand(1, 5) : null,
                    'driver_contact' => $status !== 'pending' ? '0917000' . rand(1000, 9999) : null,
                    'status' => $status === 'delivered' ? 'delivered' : ($status === 'shipped' ? 'in_transit' : 'scheduled'),
                ]);
            }
        }
    }

    private function getWeightedRandomStatus(array $distribution): string
    {
        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($distribution as $status => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $status;
            }
        }

        return 'pending';
    }

    private function generateAddress(): string
    {
        $streets = ['Main St', 'Health Ave', 'Medical Dr', 'Hospital Rd', 'Clinic St'];
        $cities = ['Imus', 'Bacoor', 'Dasmarinas', 'Cavite City', 'Tagaytay', 'Trece Martires'];

        return rand(100, 999) . ' ' . $streets[array_rand($streets)] . ', ' . $cities[array_rand($cities)] . ', Cavite';
    }
}

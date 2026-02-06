<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            $distributor = $product->distributor;
            $branches = $distributor->branches;

            // If distributor has no branches, create inventory at distributor level
            if ($branches->isEmpty()) {
                $this->createInventoryRecord($product, null);
            } else {
                // Create inventory for each branch
                foreach ($branches as $branch) {
                    $this->createInventoryRecord($product, $branch->id);
                }
            }
        }
    }

    private function createInventoryRecord(Product $product, ?int $branchId): void
    {
        $quantity = rand(20, 200);
        $reorderLevel = rand(10, 30);

        $inventoryData = [
            'product_id' => $product->id,
            'branch_id' => $branchId,
            'quantity' => $quantity,
            'reorder_level' => $reorderLevel,
            'reserved_quantity' => 0,
        ];

        // Add expiry date for products with expiry
        if ($product->has_expiry) {
            // Some items expiring soon (for DSS alerts)
            if (rand(1, 10) <= 2) {
                $inventoryData['expiry_date'] = Carbon::now()->addDays(rand(15, 45));
            } else {
                $inventoryData['expiry_date'] = Carbon::now()->addMonths(rand(6, 24));
            }
        }

        // Add batch number for consumables
        if ($product->product_type === 'consumable') {
            $inventoryData['batch_number'] = 'BATCH-' . strtoupper(substr(md5(rand()), 0, 8));
        }

        // Create some low stock items (for DSS alerts)
        if (rand(1, 10) <= 2) {
            $inventoryData['quantity'] = rand(1, $reorderLevel);
        }

        Inventory::create($inventoryData);
    }
}

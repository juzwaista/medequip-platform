<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Distributor;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $distributors = Distributor::all();

        // Sample products with realistic medical equipment data
        $productsData = [
            // Diagnostic Equipment
            [
                'category' => 'Diagnostic Equipment',
                'products' => [
                    ['name' => 'Digital Blood Pressure Monitor', 'brand' => 'Omron', 'model' => 'HEM-7120', 'base_price' => 1500, 'wholesale_price' => 1200, 'wholesale_min_qty' => 10, 'product_type' => 'equipment', 'has_warranty' => true, 'warranty_months' => 12],
                    ['name' => 'Pulse Oximeter', 'brand' => 'Beurer', 'model' => 'PO30', 'base_price' => 850, 'wholesale_price' => 700, 'wholesale_min_qty' => 20, 'product_type' => 'equipment', 'has_warranty' => true, 'warranty_months' => 6],
                    ['name' => 'Digital Thermometer', 'brand' => 'Microlife', 'model' => 'MT1931', 'base_price' => 250, 'wholesale_price' => 200, 'wholesale_min_qty' => 50, 'product_type' => 'equipment', 'has_warranty' => true, 'warranty_months' => 12],
                    ['name' => 'Stethoscope Dual Head', 'brand' => 'Littmann', 'model' => 'Classic III', 'base_price' => 4500, 'product_type' => 'equipment'],
                ]
            ],
            // Surgical Instruments
            [
                'category' => 'Scissors & Forceps',
                'products' => [
                    ['name' => 'Surgical Scissors Straight 14cm', 'brand' => 'Aesculap', 'base_price' => 1200, 'wholesale_price' => 950, 'wholesale_min_qty' => 12, 'product_type' => 'equipment'],
                    ['name' => 'Surgical Forceps Kelly 16cm', 'brand' => 'Aesculap', 'base_price' => 1500, 'wholesale_price' => 1200, 'wholesale_min_qty' => 12, 'product_type' => 'equipment'],
                    ['name' => 'Needle Holder Mayo-Hegar 18cm', 'brand' => 'Aesculap', 'base_price' => 1800, 'wholesale_price' => 1450, 'wholesale_min_qty' => 6, 'product_type' => 'equipment'],
                ]
            ],
            // PPE
            [
                'category' => 'Face Masks',
                'products' => [
                    ['name' => '3-Ply Surgical Face Mask (Box of 50)', 'brand' => 'MedGuard', 'base_price' => 250, 'wholesale_price' => 200, 'wholesale_min_qty' => 100, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'N95 Respirator Mask (Box of 20)', 'brand' => '3M', 'model' => '8210', 'base_price' => 800, 'wholesale_price' => 650, 'wholesale_min_qty' => 50, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'KN95 Face Mask (Pack of 10)', 'brand' => 'SafeGuard', 'base_price' => 350, 'wholesale_price' => 280, 'wholesale_min_qty' => 100, 'product_type' => 'consumable', 'has_expiry' => true],
                ]
            ],
            [
                'category' => 'Gloves',
                'products' => [
                    ['name' => 'Nitrile Examination Gloves Medium (Box of 100)', 'brand' => 'Ansell', 'base_price' => 450, 'wholesale_price' => 380, 'wholesale_min_qty' => 50, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Latex Examination Gloves Large (Box of 100)', 'brand' => 'TopGlove', 'base_price' => 350, 'wholesale_price' => 290, 'wholesale_min_qty' => 50, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Sterile Surgical Gloves Size 7.5 (Pair)', 'brand' => 'Medline', 'base_price' => 45, 'wholesale_price' => 35, 'wholesale_min_qty' => 200, 'product_type' => 'consumable', 'has_expiry' => true],
                ]
            ],
            // Wound Care
            [
                'category' => 'Wound Care',
                'products' => [
                    ['name' => 'Sterile Gauze Pads 4x4 (Pack of 100)', 'brand' => 'Curad', 'base_price' => 180, 'wholesale_price' => 150, 'wholesale_min_qty' => 100, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Adhesive Bandage Strips (Box of 100)', 'brand' => 'Band-Aid', 'base_price' => 120, 'wholesale_price' => 95, 'wholesale_min_qty' => 100, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Medical Tape Micropore 1 inch', 'brand' => '3M', 'base_price' => 85, 'wholesale_price' => 70, 'wholesale_min_qty' => 200, 'product_type' => 'consumable'],
                    ['name' => 'Hydrocolloid Dressing 10x10cm (Box of 10)', 'brand' => 'DuoDERM', 'base_price' => 650, 'wholesale_price' => 550, 'wholesale_min_qty' => 20, 'product_type' => 'consumable', 'has_expiry' => true],
                ]
            ],
            // Syringes & Needles
            [
                'category' => 'Syringes & Needles',
                'products' => [
                    ['name' => 'Disposable Syringe 3ml (Box of 100)', 'brand' => 'Terumo', 'base_price' => 280, 'wholesale_price' => 230, 'wholesale_min_qty' => 50, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Disposable Syringe 5ml (Box of 100)', 'brand' => 'Terumo', 'base_price' => 320, 'wholesale_price' => 260, 'wholesale_min_qty' => 50, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Hypodermic Needle 23G x 1 inch (Box of 100)', 'brand' => 'BD', 'base_price' => 250, 'wholesale_price' => 210, 'wholesale_min_qty' => 100, 'product_type' => 'consumable', 'has_expiry' => true],
                    ['name' => 'Insulin Syringe 1ml 29G (Box of 100)', 'brand' => 'BD', 'base_price' => 450, 'wholesale_price' => 380, 'wholesale_min_qty' => 50, 'product_type' => 'consumable', 'has_expiry' => true],
                ]
            ],
        ];

        foreach ($productsData as $categoryGroup) {
            $category = Category::where('name', $categoryGroup['category'])->first();

            if (!$category) {
                continue;
            }

            foreach ($categoryGroup['products'] as $productData) {
                // Randomly assign to distributors
                foreach ($distributors->random(rand(1, 2)) as $distributor) {
                    $productData['distributor_id'] = $distributor->id;
                    $productData['category_id'] = $category->id;
                    $productData['sku'] = 'SKU-' . strtoupper(substr(md5($productData['name'] . $distributor->id . rand()), 0, 8));
                    $productData['description'] = $this->generateDescription($productData['name']);
                    $productData['is_active'] = true;

                    $product = Product::create($productData);

                    // Create a placeholder product image
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'products/placeholder.jpg',
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]);
                }
            }
        }
    }

    private function generateDescription(string $name): string
    {
        return "High-quality {$name} suitable for medical and healthcare use. Complies with Philippine FDA and international quality standards.";
    }
}

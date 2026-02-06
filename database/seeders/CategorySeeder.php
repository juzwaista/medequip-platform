<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Medical Equipment',
                'description' => 'General medical equipment and devices',
                'children' => [
                    ['name' => 'Diagnostic Equipment', 'description' => 'Equipment for medical diagnosis'],
                    ['name' => 'Monitoring Devices', 'description' => 'Patient monitoring systems'],
                    ['name' => 'Imaging Equipment', 'description' => 'X-ray, ultrasound, and imaging devices'],
                ]
            ],
            [
                'name' => 'Surgical Instruments',
                'description' => 'Tools and instruments for surgical procedures',
                'children' => [
                    ['name' => 'Scissors & Forceps', 'description' => 'Surgical cutting and grasping tools'],
                    ['name' => 'Retractors', 'description' => 'Surgical retractors'],
                    ['name' => 'Scalpels & Blades', 'description' => 'Cutting instruments'],
                ]
            ],
            [
                'name' => 'Personal Protective Equipment',
                'description' => 'PPE for medical professionals',
                'children' => [
                    ['name' => 'Face Masks', 'description' => 'Surgical and N95 masks'],
                    ['name' => 'Gloves', 'description' => 'Medical examination gloves'],
                    ['name' => 'Protective Gowns', 'description' => 'Isolation and surgical gowns'],
                ]
            ],
            [
                'name' => 'Laboratory Equipment',
                'description' => 'Medical laboratory instruments and supplies',
                'children' => [
                    ['name' => 'Microscopes', 'description' => 'Laboratory microscopes'],
                    ['name' => 'Centrifuges', 'description' => 'Laboratory centrifuges'],
                    ['name' => 'Lab Consumables', 'description' => 'Test tubes, slides, etc.'],
                ]
            ],
            [
                'name' => 'Patient Care Supplies',
                'description' => 'Supplies for patient care and comfort',
                'children' => [
                    ['name' => 'Wound Care', 'description' => 'Bandages, gauze, wound dressings'],
                    ['name' => 'Mobility Aids', 'description' => 'Wheelchairs, walkers, crutches'],
                    ['name' => 'Hospital Furniture', 'description' => 'Hospital beds, tables, chairs'],
                ]
            ],
            [
                'name' => 'Consumables',
                'description' => 'Medical consumable supplies',
                'children' => [
                    ['name' => 'Syringes & Needles', 'description' => 'Injection supplies'],
                    ['name' => 'IV Supplies', 'description' => 'IV tubes, catheters, etc.'],
                    ['name' => 'Disinfectants', 'description' => 'Medical disinfectants and sanitizers'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $categoryData['slug'] = Str::slug($categoryData['name']);

            $parent = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['slug'] = Str::slug($childData['name']);
                $childData['parent_id'] = $parent->id;
                Category::create($childData);
            }
        }
    }
}

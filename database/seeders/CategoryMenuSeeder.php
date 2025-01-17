<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Burger Original',
                'price' => 15000,
                'description' => 'Burger Original dengan daging sapi pilihan',
                'categories' => ['Burger', 'Fast Food', 'Snack'],
            ],
            [
                'name' => 'Burger Cheese',
                'price' => 20000,
                'description' => 'Burger Cheese dengan daging sapi pilihan dan keju',
                'categories' => ['Burger', 'Fast Food', 'Snack'],
            ],
            [
                'name' => 'Burger Double Cheese',
                'price' => 25000,
                'description' => 'Burger Double Cheese dengan daging sapi pilihan dan keju',
                'categories' => ['Burger', 'Fast Food', 'Snack'],
            ],
            [
                'name' => 'Nasi Goreng',
                'price' => 20000,
                'description' => 'Nasi Goreng dengan bumbu rempah',
                'categories' => ['Nasi', 'Fast Food'],
            ],
            [
                'name' => 'Nasi Goreng Seafood',
                'price' => 25000,
                'description' => 'Nasi Goreng dengan bumbu rempah dan seafood',
                'categories' => ['Nasi', 'Fast Food'],
            ],
            [
                'name' => 'Es Teh',
                'price' => 5000,
                'description' => 'Es Teh manis',
                'categories' => ['Minuman', 'Beverage'],
            ],
            [
                'name' => 'Es Jeruk',
                'price' => 7000,
                'description' => 'Es Jeruk manis',
                'categories' => ['Minuman', 'Beverage'],
            ],
            [
                'name' => 'Es Campur',
                'price' => 10000,
                'description' => 'Es Campur manis',
                'categories' => ['Minuman', 'Beverage'],
            ],
        ];

        foreach ($menus as $menu) {
            $categories = $menu['categories'];
            unset($menu['categories']);

            $menu = \App\Models\Menu::factory()->create($menu);

            foreach ($categories as $category) {
                $category = \App\Models\Category::firstOrCreate(['name' => $category]);
                $menu->categories()->attach($category->id);
            }
        }
    }
}

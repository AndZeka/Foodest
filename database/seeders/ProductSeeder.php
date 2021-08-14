<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name'=>'Hamburger',
            'slug'=>'hamburger',
            'description'=>'Best hamburger in town',
            'photo'=>'default.png',
            'price'=>7.99,
            'sale_price'=>0,
            'restaurant_id'=>1
        ]);
    }
}

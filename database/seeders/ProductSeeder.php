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
        Product::create([
            'name'=>'Pizza',
            'slug'=>'pizza',
            'description'=>'Best pizza in town',
            'photo'=>'default.png',
            'price'=>6,
            'sale_price'=>0,
            'restaurant_id'=>1
        ]);
        Product::create([
            'name'=>'Sandwich',
            'slug'=>'sandwich',
            'description'=>'Best sandwich in town',
            'photo'=>'default.png',
            'price'=>4.5,
            'sale_price'=>0,
            'restaurant_id'=>1
        ]);
        Product::create([
            'name'=>'Fish',
            'slug'=>'fish',
            'description'=>'Best fish in town',
            'photo'=>'default.png',
            'price'=>12,
            'sale_price'=>0,
            'restaurant_id'=>1
        ]);
    }
}

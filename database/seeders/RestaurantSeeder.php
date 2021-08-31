<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::create(
            [
                'name'=>'Aba',
                'user_id'=>1,
                'slug'=>'aba',
                'lat'=>53.4620,
                'lng'=>-2.2493,
                'photo'=>'default.png',
                'address'=>'Afrim Loxha, Prishtine',
                'postcode'=>'10000',
            ]
        );

        Restaurant::create(
            [
                'name'=>'Skenda',
                'user_id'=>2,
                'slug'=>'skenda',
                'lat'=>53.4620,
                'lng'=>2.2493,
                'photo'=>'default.png',
                'address'=>'Afrim Loxha, Prishtine',
                'postcode'=>'10000',
            ]
        );
    }
}

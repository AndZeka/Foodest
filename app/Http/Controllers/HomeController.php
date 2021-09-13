<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Product;

class HomeController extends Controller
{
    public function home()
    {
        $restaurants = Restaurant::limit(6)->get();
        $products = Product::limit(3)->get();
        $products8 = Product::limit(8)->get();

        return view('home', [
            "products" => $products,
            "restaurants" => $restaurants,
            "products8" => $products8
        ]);
    }
    public function contact(){
        return view('contact');
    }
}

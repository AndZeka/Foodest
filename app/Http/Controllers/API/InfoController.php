<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;

class InfoController extends Controller
{
    public function index(){
        $restaurants = Restaurant::all()->count();
        $orders = Order::all()->count();
        $users = User::all()->count();
        $products = Product::all()->count();

        return [
            "products" => $products,
            "restaurants" => $restaurants,
            "users" => $users,
            "orders" => $orders
        ];
    }
}

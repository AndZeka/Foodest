<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Comments;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $restaurant = Restaurant::where('slug', $request->slug)->first();
        $comments = Comments::where('restaurant_id', $restaurant->id)->get();

        return view('products', [
            "products" => $restaurant->products,
            "restaurant" => $restaurant,
            "id"=>$restaurant->id,
            "comments"=>$comments
        ]);
    }
}

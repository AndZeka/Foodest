<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index(Request $request){
        $query = $request->input('search');
        if(!empty($query)) {
            // categories 
            $restaurants = Restaurant::where('name', 'like', '%'.$query.'%')->paginate(10);
            return view('restaurants', [
                'restaurants' => $restaurants
            ]);
        }
        return back();
    }
}

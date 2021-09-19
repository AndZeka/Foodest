<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use DB;

class RestaurantOrdersController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = auth()->user()->id;
        
        $currentRestaurant =  DB::table('restaurants')
            ->join('users', 'restaurants.user_id', '=', 'users.id')
            ->select('restaurants.id')            
            ->where('restaurants.user_id', '=', $currentUser)->first();

        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $orders = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id')
            ->join('products', 'orders_details.product_id', '=', 'products.id')
            // ->join('restaurants',$currentUser,'=','restaurants.user_id')
            ->select('orders_details.id', 'orders_details.qty', 'orders_details.price', 'orders.status', 'products.name')            
            ->where('products.restaurant_id', '=', $currentRestaurant->id)
            // ->where('restaurants.user_id','=',$currentUser)
            ->latest('orders_details.created_at')->paginate(10);
            
            return $orders;
        }
    }

    public function name(){
        $currentUser = auth()->user()->id;

        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $restaurant = DB::table('restaurants')
            ->join('users', 'restaurants.user_id', '=', 'users.id')
            ->select('restaurants.name')            
            ->where('restaurants.user_id', '=', $currentUser)
            ->latest('restaurants.created_at')->paginate(10);
            
            return $restaurant;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(){
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            if($search = \Request::get('q')){
                $myorders = OrderDetail::where(function($query) use ($search){
                    $query->where('id','LIKE',"%$search%")
                    ->orWhere('qty','LIKE',"%$search%");
                })->latest()->paginate(20);
            }else{
                $myorders = OrderDetail::latest()->paginate(5);
            }
            return $myorders;
        }
    }
}

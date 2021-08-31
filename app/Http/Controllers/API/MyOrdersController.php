<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Hash;
use DB;

class MyOrdersController extends Controller
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant') || \Gate::allows('isUser')){
            $orders = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id')
            ->join('products', 'orders_details.product_id', '=', 'products.id')
            ->select('orders_details.id', 'orders_details.qty', 'orders_details.price', 'orders.status', 'products.name')            
            ->where('orders.user_id', '=', $currentUser)
            ->latest('orders_details.created_at')->paginate(5);
            
            return $orders;
        }
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

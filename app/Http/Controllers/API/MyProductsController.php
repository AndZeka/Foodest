<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;

class MyProductsController extends Controller
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
            ->where('restaurants.user_id', '=', $currentUser)
            ->first();
        

        if(\Gate::allows('isAdmin')){
            return Product::latest()->paginate(5);
        }else if(\Gate::allows('isRestaurant')){
            return Product::where('restaurant_id', $currentRestaurant->id)->latest()->paginate(5);
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $currentUser = auth()->user()->id;

            $currentRestaurant = DB::table('restaurants')
                ->join('users', 'restaurants.user_id', '=', 'users.id')
                ->select('restaurants.id')            
                ->where('restaurants.user_id', '=', $currentUser)
                ->first();

            $this->validate($request,[
                'name' => 'required|string|max:191',
                'restaurant_id' => 'required|integer',
                'slug' => 'required|string|max:191',
                'description' => 'required',
                'price' => 'required',
            ]);

            return Product::create([
                'restaurant_id'=>$currentRestaurant->id,
                'name'=>$request['name'],
                'slug'=>$request['slug'],
                'description'=>$request['description'], 
                'price'=>$request['price'],           
                'photo'=>$request['photo']     
            ]);
        }
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $product = Product::findOrFail($id);

            $currentUser = auth()->user()->id;

            $currentRestaurant =  DB::table('restaurants')
                ->join('users', 'restaurants.user_id', '=', 'users.id')
                ->select('restaurants.id')            
                ->where('restaurants.user_id', '=', $currentUser)
                ->first();

            $this->validate($request,[
                'name' => 'required|string|max:191',
                'restaurant_id' => 'required|integer',
                'slug' => 'required|string|max:191',
                'description' => 'required',
                'price' => 'required',
            ]);
        

            $product->update($request->all());
            return $id;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdminOrRestaurant');
        $product = Product::findOrFail($id);
        $product->delete();
        return ['message'=>'Restaurant Deleted'];
    }

    public function getUserRole(){
        return auth()->user()->type;
    }

    public function search(){
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            if($search = \Request::get('q')){
                $myproducts = Product::where(function($query) use ($search){
                    $query->where('name','LIKE',"%$search%")
                    ->orWhere('slug','LIKE',"%$search%")
                    ->orWhere('description','LIKE',"%$search%");
                })->latest()->paginate(20);
            }else{
                $myproducts = Product::latest()->paginate(5);
            }
            return $myproducts;
        }
    }

    public function updatePhoto(Request $request){
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $currentUser = auth()->user()->id;

            $currentRestaurant =  DB::table('restaurants')
                ->join('users', 'restaurants.user_id', '=', 'users.id')
                ->select('restaurants.id')            
                ->where('restaurants.user_id', '=', $currentUser)
                ->first();
            
            $product = Product::where('restaurant_id', $currentRestaurant->id)->first();

            $currentPhoto = $product->photo;
            if($request->photo != $currentPhoto){
                $name = time().'.'.explode('/',explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                //Image intervation model class
                \Image::make($request->photo)->save(public_path('imgs/foods/').$name);
                
                $request->merge(['photo' => $name]);

                $foodPhoto = public_path('imgs/foods/').$currentPhoto;
                if(file_exists($foodPhoto)){
                    @unlink($foodPhoto);
                }
            }        

            $product->update($request->all());
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use DB;

class MyRestaurantsController extends Controller
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
        if(\Gate::allows('isAdmin')){
            return Restaurant::latest()->paginate(5);
        }else if(\Gate::allows('isRestaurant')){
            return Restaurant::where('user_id', $currentUser)->latest()->paginate(5);
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
        $currentUser = auth()->user()->id;
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'user_id' => 'required|integer',
            'slug' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'postcode' => 'string|max:191',
        ]);

        return Restaurant::create([
            'user_id'=>$currentUser,
            'lat'=>1,
            'lng'=>1,
            'name'=>$request['name'],
            'slug'=>$request['slug'],
            'address'=>$request['address'], 
            'postcode'=>$request['postcode'],        
            'photo'=>$request['photo']
        ]);
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
        $restaurant = Restaurant::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'user_id' => 'required|integer',
            'slug' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'postcode' => 'string|max:191',
        ]);

        $restaurant->update($request->all());
        return $id;
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
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        return ['message'=>'Restaurant Deleted'];
    }

    public function getUserRole(){
        return auth()->user()->type;
    }

    public function getNumberOfRestaurantsByUser(){
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $currentUser = auth()->user()->id;

            $restaurantCount = DB::table('restaurants')
                ->join('users', 'restaurants.user_id', '=', 'users.id')
                ->select('restaurants.*')            
                ->where('restaurants.user_id', '=', $currentUser)
                ->count();

            return $restaurantCount;
        }
    }

    public function singleRestaurant(){
        if(\Gate::allows('isAdmin') || \Gate::allows('isRestaurant')){
            $currentUser = auth()->user()->id;

            $restaurant = DB::table('restaurants')
                ->join('users', 'restaurants.user_id', '=', 'users.id')
                ->select('restaurants.*')            
                ->where('restaurants.user_id', '=', $currentUser)
                ->latest('restaurants.created_at');

            return $restaurant;
        }
    }

    public function search(){
        if($search = \Request::get('q')){
            $myrestaurants = Restaurant::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                ->orWhere('slug','LIKE',"%$search%");
            })->latest()->paginate(20);
        }else{
            $myrestaurants = Restaurant::latest()->paginate(5);
        }
        return $myrestaurants;
    }

    public function updatePhoto(Request $request){
        $user = auth('api')->user();

        $restaurant = DB::table('restaurants')
            ->join('users', 'restaurants.user_id', '=', 'users.id')
            ->select('restaurants.*')            
            ->where('restaurants.user_id', '=', $user->id)
            ->first();

        $currentPhoto = $restaurant->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.'.explode('/',explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            //Image intervation model class
            \Image::make($request->photo)->save(public_path('imgs/restaurant/').$name);
            
            $request->merge(['photo' => $name]);

            $userPhoto = public_path('imgs/restaurant/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }        

        $restaurant->update($request->all());
    }
}

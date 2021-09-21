<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MyOrdersController;
use App\Http\Controllers\API\MyRestaurantsController;
use App\Http\Controllers\API\MyProductsController;
use App\Http\Controllers\API\RestaurantOrdersController;
use App\Http\Controllers\API\InfoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user'=>UserController::class, 
    'myorders'=>MyOrdersController::class, 
    'myrestaurants'=>MyRestaurantsController::class, 
    'myproducts'=>MyProductsController::class,
    'restaurantorders'=>RestaurantOrdersController::class, 
]); 

Route::get('profile',[UserController::class,'profile']);
Route::put('profile',[UserController::class,'updateProfile']);
Route::get('findUser',[UserController::class,'search']);
Route::get('findOrder',[MyOrdersController::class,'search']);
Route::get('findRestaurantName',[RestaurantOrdersController::class,'name']);
Route::get('findRestaurantOrder',[RestaurantOrdersController::class,'search']);
Route::get('findRestaurant',[MyRestaurantsController::class,'search']);
Route::put('photo',[MyRestaurantsController::class,'updatePhoto']);
Route::get('role',[MyRestaurantsController::class,'getUserRole']);
Route::get('restaurantCount',[MyRestaurantsController::class,'getNumberOfRestaurantsByUser']);
Route::get('singleRestaurant',[MyRestaurantsController::class,'singleRestaurant']);
Route::get('roleProduct',[MyProductsController::class,'getUserRole']);
Route::get('findProduct',[MyProductsController::class,'search']);
Route::put('foodPhoto',[MyProductsController::class,'updatePhoto']);
Route::get('info',[InfoController::class,'index']);

//Checkout
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){
    Route::get('/user/setup-intent', [UserController::class, 'getSetupIntent']);
    Route::get('/user/payment-methods', [UserController::class, 'getPaymentMethods'])->name('user.paymentMethods');
});



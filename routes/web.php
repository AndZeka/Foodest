<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('restaurants', [RestaurantController::class, 'index'])->name('search.restaurants');


Route::group(['middleware' => ['web','auth']], function() {
    
    Route::get('restaurant/{slug}', [ProductController::class, 'index'])->name('restaurant.products');
    //Basket
    Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/basket', [BasketController::class, 'store'])->name('basket.store');

    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // Route::get('/user/setup-intent', [UserController::class, 'getSetupIntent']);
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::DELETE('/basket/{basket}', [BasketController::class, 'destroy'])->name('basket.destroy');
    
});
Route::get('/{any}', [HomeController::class,'index'])->where('any', '.*');

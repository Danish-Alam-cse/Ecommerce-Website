<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\Cart;
use Illuminate\Support\Facades\Auth;
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

use App\Models\Product;
Route::get('/', function () {
    return view('home.index',['pro'=>Product::all()]);
})->name('homepage');
Route::get('/cart', [Cart::class, 'cart'])->name('cart');
Route::get('/myorder', [Cart::class, 'myorder'])->name('myorder');
Route::get('/cart/remove/{item_id}', [Cart::class, 'remove_item'])->name('removeitem');
Route::get('/checkout', [Cart::class, 'checkout'])->name('checkout');
Route::post('/insert-checkout', [Cart::class, 'insertCheckout'])->name('insert_checkout');
Route::post('/make-payment', [Cart::class, 'makePayment'])->name('makePayment');

Route::get('/payment/now', [Cart::class, 'order'])->name('pay');
Route::post('/payment/status', [Cart::class,'paymentCallback'])->name('status');


Route::get('/addToCart/{item_id}',[Cart::class,'addToCart'])->name('addtocart');
Route::get('/removeFromCart/{item_id}',[Cart::class,'removeCart'])->name('removecart');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

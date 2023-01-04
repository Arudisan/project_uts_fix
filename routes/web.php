<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
// use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryProductController;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\ExampleController::class, 'example'])->name('dashboard');
    Route::resource('/product', ProductController::class);
    Route::resource('/category', CategoryProductController::class);
    Route::resource('/transaction', TransactionController::class);
    Route::resource('/checkout', CheckoutController::class);
    Route::get('/chart', [CheckoutController::class, 'chart'])->name('chart');
});

// Route::get('/send-mail',fuction() {
//     Mail::to('newuser@example.com')->send(new MailtrapExample());
//     return 'A message has been sent to MailTrap';

<?php


use App\Http\Controllers\Home_Controller;
use App\Http\Controllers\User_Controller;
use App\Http\Controllers\Admin_Controller;
use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});


Route::prefix('user')
    ->middleware('auth')
    ->group(function () {
      Route::get('dashboard', [User_Controller::class, 'dashboard'])->name('dashboard');
    });

Route::prefix('product')
    ->group(function () {
        Route::get('search', [ProductsController::class, 'searchProduct'])->name('search-product');
        Route::get('see/{ID}', [ProductsController::class, 'see'])->name('see-product');
        Route::get('all', [ProductsController::class, 'all'])->name('all');
        Route::get('newproduct', [ProductsController::class, 'newProduct'])->name('new-product')->middleware('auth');
        Route::post('postProduct', [ProductsController::class, 'postProduct'])->name('post-product')->middleware('auth');
    });

Route::prefix('order')
    ->group(function () {
        Route::get('search', [OrdersController::class, 'searchOrder'])->name('search-order');
        Route::get('all', [OrdersController::class, 'all'])->name('all');
        Route::get('order', [OrdersController::class, 'vendiProdotto'])->name('vendi-prodotto')->middleware('auth');
        Route::post('postorder', [OrdersController::class, 'caricaProdotto'])->name('carica-prodotto')->middleware('auth');

    });




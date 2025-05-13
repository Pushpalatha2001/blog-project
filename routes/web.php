<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');  
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Blog routes
    Route::controller(BlogController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'Edit')->name('edit');
        Route::post('/update', 'Update')->name('update');


    });
      Route::controller(CommentController::class)->group(function () {
        Route::post('/comment/store', 'CommentStore')->name('comment_store');
       
    });
    Route::middleware('auth')->controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'ProductAll')->name('product_all');
        Route::get('/product/add', 'ProductAdd')->name('product_add');
        Route::post('/product/store', 'ProductStore')->name('product_store');
        Route::get('/product/edit/{id}', 'ProductEdit')->name('product_edit');
        Route::post('/product/update', 'ProductUpdate')->name('product_update');

        Route::get('/order/all', 'OrderAll')->name('order_all');
        Route::get('/order/add', 'OrderAdd')->name('order_add');
        Route::post('/order/store', 'OrderStore')->name('order_store');
        Route::get('/order/edit/{id}', 'OrderEdit')->name('order_edit');
        Route::post('/order/update', 'OrderUpdate')->name('order_update');


    });
        Route::middleware('auth')->controller(UserController::class)->group(function () {
        Route::get('/user/all', 'UserAll')->name('user_all');
       

    });
});

require __DIR__.'/auth.php';


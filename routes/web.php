<?php

use App\Http\Controllers\ImagesController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



//DB::listen(function ($query) { //Ver las querys en el listener
//    dump($query->sql);
//});

Route::view('/','welcome')->name('welcome');



//Breeze
Route::get('locale', [LanguageController::class, 'select'])->name('lang.select');

Route::middleware('auth')->group(function () {

    //todo; Product

    Route::get('/products', [ProductController::class,'index'])->name('products.list');
    Route::post('/product', [ProductController::class,'store'])->name('products.store');
    Route::get('/product-edit/{id}', [ProductController::class,'update'])->name('product.update');
    Route::get('/product-show/{id}', [ProductController::class,'show'])->name('product.show');
    Route::put('/product-update', [ProductController::class,'edit'])->name('product.edit');
    Route::delete('/product-delete',[ProductController::class,'destroy'])->name('product.destroy');

    //todo; Image

    Route::delete('/image-delete',[ImagesController::class,'destroy'])->name('image.destroy');
    Route::put('/image-update',[ImagesController::class,'update'])->name('image.update');


    Route::get('/dashboard', function () {
        return view('dashboard');

    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

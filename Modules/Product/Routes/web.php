<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    //Print Barcode
    Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');
    Route::get('/printToExcel/{id}', 'ProductController@toExcel')->name('category.printToExcel.id'); 
    Route::resource('products', 'ProductController');


    Route::middleware([CheckPermission::class . ':access_product_categories'])->group(function () {
        //Product Category
        Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
    });
});

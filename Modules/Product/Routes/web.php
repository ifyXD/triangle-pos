<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Middleware\CheckPermission;

Route::group(['middleware' => 'auth'], function () {
    //Print Barcode
    Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');
    Route::get('/printToExcel/{id}', 'ProductController@toExcel')->name('category.printToExcel.id');
    //Product 
    Route::middleware([CheckPermission::class . ':create_products'])->group(function () {
        Route::get('products/create', 'ProductController@create');
    });
    Route::middleware([CheckPermission::class . ':edit_products'])->group(function () {
        Route::get('products/{id}/edit', 'ProductController@edit');
    });
    Route::middleware([CheckPermission::class . ':show_products'])->group(function () {
        Route::get('products/{id}', 'ProductController@show');
    });  
    Route::middleware([CheckPermission::class . ':access_products'])->group(function () {
        Route::resource('products', 'ProductController')->only('store','index','create');
    });
  

    Route::middleware([CheckPermission::class . ':access_product_categories'])->group(function () {
        //Product Category 
        Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
    });
});

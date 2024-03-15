<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    //Print Barcode
    Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');
    Route::get('/hehe/{id}', 'ProductController@hehe')->name('hehe.id');
    //Product
    Route::resource('products', 'ProductController');
    //Product Category
    Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
});


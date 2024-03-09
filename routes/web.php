<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Route::get('/', function () {
    return view('homepage');
})->middleware('guest');
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest');




Auth::routes(['register' => true]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')->name('sales-purchases.chart');
    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')->name('current-month.chart');
    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')->name('payment-flow.chart');
});




Route::resource('expense', 'ExpenseController');


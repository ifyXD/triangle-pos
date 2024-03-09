<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PartiesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Route::get('/', function () {
    return view('layouts.home.index');
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



Route::resources([
    'expense' => ExpenseController::class,
    'parties' => PartiesController::class,
    'product' => ProductController::class,
    'purchase' => PurchaseController::class,
    'report' => ReportController::class,
    'sale' => SaleController::class,
    'stock' => StockAdjustmentController::class,
    'user' => UserManagementController::class,
]);

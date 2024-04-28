<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartiesController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/* GI SIMPLIFY NKO WAWAWAWAWA UWU */
//Route::get('/', function () {return view('layouts.home.index');})->middleware('guest');
//Route::get('/trial', function () {return view('auth.trial-register');})->middleware('guest');
//Route::get('/login', function () {return view('auth.login');})->middleware('guest');
//Route::get('/trial', function () {return view('auth.login');})->middleware('guest');


Route::middleware('guest')->group(function () {
    Route::view('/', 'layouts.home.index');
    Route::view('/trial', 'auth.trial-register');
    Route::view('/login', 'auth.login');
    // If '/trial' and '/login' should point to the same view, keep only one of them
});



Auth::routes([
    'register' => true,
    'verify' => true
]);

Route::get('/userlist', [HomeController::class, 'userlist']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->middleware('verified','isRequirement')->name('home');

    // Requirement 1
    Route::middleware('verified','isCheckRequirement')->group(function () {
        Route::get('/registration-requirements-storename', [HomeController::class, 'storename'])->name('registration.requirements-storename');
        Route::get('/registration-requirements-permission', [HomeController::class, 'permission'])->name('registration.requirements-permission');
        Route::get('/registration-requirements-colorpallete', [HomeController::class, 'colorpallete'])->name('registration.requirements-colorpallete');
    });

    Route::post('/update-requirements', [HomeController::class, 'updaterequirements'])->name('updaterequirements');
    Route::post('/update-session/registration-requirements', [HomeController::class, 'updateSession']);
    Route::post('/update-session/registration-requirements/withpermission', [HomeController::class, 'withPermission']);
    Route::post('/update-session/registration-requirements/withpermission_update', [HomeController::class, 'withPermission_update']);

    Route::post('/update/registration-requirements', [HomeController::class, 'update_requirements']);

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')->name('sales-purchases.chart');
    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')->name('current-month.chart');
    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')->name('payment-flow.chart');
    Route::resource('prices', 'PriceController');
    Route::resource('stocks', 'StockController');

    Route::get('prices/create/{id}', 'PriceController@create');
    Route::patch('prices/store/{id}', 'PriceController@store')->name('prices.store');
    Route::patch('prices/update/{id}', 'PriceController@update')->name('prices.update');
    Route::get('prices/show/{id}', 'PriceController@show')->name('prices.show');
    Route::get('prices/edit/{id}', 'PriceController@edit');
    Route::delete('prices/delete/{id}', 'PriceController@destroy')->name('prices.destroy');
    
    Route::get('stocks/create/{id}', 'StockController@create');
    Route::patch('stocks/store/{id}', 'StockController@store')->name('stocks.store');
    Route::patch('stocks/update/{id}', 'StockController@update')->name('stocks.update');
    Route::get('stocks/show/{id}', 'StockController@show')->name('stocks.show');
    Route::get('stocks/edit/{id}', 'StockController@edit');
    Route::delete('stocks/delete/{id}', 'StockController@destroy')->name('stocks.destroy');

});




Route::resources([
//    'expense' => ExpenseController::class,
//    'parties' => PartiesController::class,
//    'product' => ProductController::class,
//    'purchase' => PurchaseController::class,
//    'reports' => ReportController::class,
//    'sale' => SaleController::class,
//    'stock' => StockAdjustmentController::class,
//    'user' => UserManagementController::class,
    'pos' => POSController::class,

    'about' => AboutController::class,
    'contact' => ContactController::class
]);

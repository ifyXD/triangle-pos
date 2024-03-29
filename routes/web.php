<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
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
Route::get('/trial', function () {
    return view('auth.trial-register');
})->middleware('guest');
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest');
Route::get('/trial', function () {
    return view('auth.login');
})->middleware('guest');
Auth::routes(['register' => true]);

Route::get('/userlist', [HomeController::class, 'userlist']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->middleware('isRequirement')->name('home');

    // Requirement 1
    Route::middleware('isCheckRequirement')->group(function () {
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
});

Route::resources([
    'expense' => ExpenseController::class,
    'parties' => PartiesController::class,
    'product' => ProductController::class,
    'purchase' => PurchaseController::class,
    'reports' => ReportController::class,
    'sale' => SaleController::class,
    'stock' => StockAdjustmentController::class,
    'user' => UserManagementController::class,
]);

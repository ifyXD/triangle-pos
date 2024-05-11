<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Modules\Sale\Entities\SaleDetails;

Route::group(['middleware' => 'auth'], function () {

    //POS
    Route::get('/app/pos', 'PosController@index')->name('app.pos.index');
    Route::post('/app/pos', 'PosController@store')->name('app.pos.store');

    //Generate PDF
    Route::get('/sales/pdf/{id}', function ($id) {
        $sale = \Modules\Sale\Entities\Sale::findOrFail($id);
        $sale_details = SaleDetails::where('sale_details.sale_id', $id)
            ->join('products', 'sale_details.product_id', 'products.id')
            ->join('units', 'sale_details.unit_id', 'units.id')
            ->join('prices', 'sale_details.price_id', 'prices.id')
            ->select('products.product_name as product_name', 'units.name as unit_name', 'prices.product_price as product_price', 'sale_details.quantity as quantity', 'sale_details.id as id' )
            ->get();
        $customer = \Modules\People\Entities\Customer::findOrFail($sale->customer_id);

        $pdf = FacadePdf::loadView('sale::print', [
            'sale' => $sale,
            'customer' => $customer,
            'sale_details' => $sale_details,
        ])->setPaper('a4');

        return $pdf->stream('sale-' . $sale->reference . '.pdf');
    })->name('sales.pdf');

    Route::get('/sales/pos/pdf/{id}', function ($id) {
        $sale = \Modules\Sale\Entities\Sale::findOrFail($id);
        $sale_details = \Modules\Sale\Entities\SaleDetails::where('sale_id', $id)->get();

        $pdf = FacadePdf::loadView('sale::print-pos', [
            'sale' => $sale,
            'sale_details' => $sale_details,
        ])->setPaper('a7')
            ->setOption('margin-top', 8)
            ->setOption('margin-bottom', 8)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5);


        return $pdf->stream('sale-' . $sale->reference . '.pdf');
    })->name('sales.pos.pdf');

    //Sales
    Route::resource('sales', 'SaleController');

    //Payments
    Route::get('/sale-payments/dispatch/{sale_id}', 'SalePaymentsController@dispatch')->name('sale-payments.dispatch');
    Route::get('/sale-payments/{sale_id}', 'SalePaymentsController@index')->name('sale-payments.index');
    Route::get('/sale-payments/{sale_id}/create', 'SalePaymentsController@create')->name('sale-payments.create');
    Route::post('/sale-payments/store', 'SalePaymentsController@store')->name('sale-payments.store');
    Route::get('/sale-payments/{sale_id}/edit/{salePayment}', 'SalePaymentsController@edit')->name('sale-payments.edit');
    Route::patch('/sale-payments/update/{salePayment}', 'SalePaymentsController@update')->name('sale-payments.update');
    Route::delete('/sale-payments/destroy/{salePayment}', 'SalePaymentsController@destroy')->name('sale-payments.destroy');
});

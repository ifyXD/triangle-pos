<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Product\DataTables\PriceDataTable; 

class PriceController extends Controller
{
    public function index(PriceDataTable $dataTable)
    {
        abort_if(Gate::denies('access_prices'), 403);

        return $dataTable->render('prices.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Figures\Product;
use App\Models\Price;
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
    public function create($id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        $data = Product::find($id);
        $units = explode(',', $data->product_unit);
        $savedUnits = Price::where('product_id', $id)->pluck('product_unit')->toArray(); // Array of saved units
        return view('prices.partials.create', compact('id', 'data', 'units', 'savedUnits'));
    }

    public function store(Request $request, $id)
    {
        abort_if(Gate::denies('access_prices'), 403);
        Price::create([
            'product_id' => $request->product_id,
            'product_unit' => $request->product_unit,
            'product_cost' => $request->product_cost,
            'product_price' => $request->product_price,
        ]);
    }
    public function show($id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        $product = Product::find($id);
        $units = explode(',', $product->product_unit);
        $savedUnits = Price::where('product_id', $id)->pluck('product_unit')->toArray(); // Array of saved units
        return view('prices.partials.show', compact('id', 'product', 'units', 'savedUnits'));
    }
}

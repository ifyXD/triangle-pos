<?php

namespace App\Http\Controllers;

use App\Models\Figures\Product;
use App\Models\Price;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Product\DataTables\StockDataTable;
use Modules\Setting\Entities\Unit;

class StockController extends Controller
{
    public function index(StockDataTable $dataTable)
    {
        abort_if(Gate::denies('access_prices'), 403);

        return $dataTable->render('stocks.index');
    }
    public function create($id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        $units = Unit::where('store_id', auth()->user()->store->id)->orderBy('name', 'asc')->get();
        $data = Product::find($id);
        return view('stocks.partials.create', compact('id', 'data', 'units'));
    }

    public function store(Request $request, $id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        Stock::create([
            'product_id' => $request->product_id,
            'unit_id' => $request->unit_id,
            'product_quantity' => $request->product_quantity,
            'product_stock_alert' => $request->product_stock_alert,
            'store_id' => auth()->user()->store->id,
        ]);

        return redirect('prices/show/' . $id);
    }
    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        $units = Unit::where('store_id', auth()->user()->store->id)->orderBy('name', 'asc')->get();
        $data = Product::find($id);
        $stock_id = Stock::find($id)->unit_id;
        $stock = Stock::find($id);
        return view('stocks.partials.edit', compact('id','stock_id', 'data', 'units','stock'));

        // return redirect('prices/show/' . $id);
    }
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        $price = Price::find($id);
        $price->update([
            'product_cost' => $request->product_cost,
            'product_price' => $request->product_price,
        ]);

        return redirect('prices/show/' . $price->product_id)->with('success', 'Price Updated!');
    }
    public function show($id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        $product = Product::find($id);
        $stocks = DB::table('stocks')
            ->select([
                'stocks.product_quantity as product_quantity',
                'stocks.id as stock_id',
                'units.id as unit_id',
                'units.name as name',
                'units.short_name as short_name'
            ])
            ->join('units', 'stocks.unit_id', 'units.id')
            ->where('stocks.product_id', $id)
            ->get();



        return view('stocks.partials.show', compact('id', 'product', 'stocks'));
    }
    public function destroy($id)
    {
        abort_if(Gate::denies('access_prices'), 403);

        Price::find($id)->delete();

        toast('Product Deleted!', 'warning');

        return redirect()->back()->with('success', 'Price Deleted!');
    }
}

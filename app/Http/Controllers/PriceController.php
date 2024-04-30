<?php

namespace App\Http\Controllers;

use App\Models\Figures\Product;
use App\Models\Price;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Product\DataTables\PriceDataTable;
use Modules\Setting\Entities\Unit;

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
        $units = Stock::where('product_id', $id)->select('unit_id','id')->get();
        $savedUnits = Price::where('product_id', $id)->get('unit_id');

        $unitArray = array();

        foreach($units as $unit){
            $units_list = Unit::where('id',$unit->unit_id)->get();
            foreach($units_list as $unitl){
                $unitArray[] = [
                    'id' => $unitl->id,
                    'name' => $unitl->name,
                    'short_name' => $unitl->short_name,
                    'stock_id' => $unit->id,
                ];
            }
        }
        // echo $savedUnits;
        
        return view('prices.partials.create', compact('id', 'data', 'unitArray', 'savedUnits'));
    }

    public function store(Request $request, $id)
    {
        abort_if(Gate::denies('access_prices'), 403);
        Price::create([
            'product_id' => $request->product_id,
            'unit_id' => $request->product_unit,
            'product_cost' => $request->product_cost,
            'product_price' => $request->product_price,
            'stock_id' => $request->stock_id,
        ]);

        return redirect('prices/show/' . $id);
    }
    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('access_prices'), 403); 
      
        $data = Price::find($id);
        // $units = explode(',', $data->product_unit);
      
        $unit = DB::table('prices')->where('prices.id',$id)->join('units','prices.unit_id', 'units.id')->select('units.name as name', 'units.short_name as short_name')->first();
        
        return view('prices.partials.edit', compact('id', 'data','unit'));

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
        $prices = DB::table('prices')
        ->join('units', 'prices.unit_id', 'units.id')
        ->where('prices.product_id', $id)
        ->select('prices.id as id','prices.unit_id as product_id','prices.product_cost as product_cost','prices.product_price as product_price', 'units.id as unit_id', 'units.name as name', 'units.short_name as short_name')
        ->get();
        return view('prices.partials.show', compact('id', 'product', 'prices'));
    }
    public function destroy($id)
    { 
        abort_if(Gate::denies('access_prices'), 403);

        Price::find($id)->delete();

        toast('Product Deleted!', 'warning');

        return redirect()->back()->with('success', 'Price Deleted!');

    }
}

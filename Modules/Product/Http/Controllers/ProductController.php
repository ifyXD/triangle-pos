<?php

namespace Modules\Product\Http\Controllers;

use Modules\Product\DataTables\ProductDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Upload\Entities\Upload;

class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable)
    {
        abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('product::products.index');
    }


    public function create()
    {
        // abort_if(Gate::denies('create_products'), 403);
        $this->checkPermission('create_products');

        return view('product::products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $this->checkPermission('create_products');

        // Set user_id from the authenticated user
        $request->merge(['store_id' => auth()->user()->store->id]);

        // Convert the array of selected units to a comma-separated string
        // $productUnits = implode(',', $request->input('product_unit', []));

        // Create the product with the units
        // $productData = $request->except(['document', 'product_unit']);
        $productData = $request->except(['document']);
        // $productData['product_unit'] = $productUnits;

        $product = Product::create($productData);

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }






    public function show(Product $product)
    {
        // abort_if(Gate::denies('show_products'), 403);
        $this->checkPermission('show_products');
        $product->user_id = auth()->user()->store->id;
        return view('product::products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        // abort_if(Gate::denies('edit_products'), 403);
        $this->checkPermission('edit_products');


        return view('product::products.edit', compact('product'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->checkPermission('edit_products');

        $productUnits = implode(',', $request->input('product_unit', []));

        $product->update([
            'category_id' => $request->input('category_id'),
            'product_name' => $request->input('product_name'),
            'product_stock_alert' => $request->input('product_stock_alert'), 
            'product_quantity' => $request->input('product_quantity'), 
            'product_note' => $request->input('product_note'), 
            'product_unit' => $productUnits,
        ]);

        if ($request->has('document')) {
            if (count($product->getMedia('images')) > 0) {
                foreach ($product->getMedia('images') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $product->getMedia('images')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                }
            }
        }

        toast('Product Updated!', 'info');

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        // abort_if(Gate::denies('delete_products'), 403);
        $this->checkPermission('delete_products');

        $product->delete();

        toast('Product Deleted!', 'warning');

        return redirect()->route('products.index');
    }
    protected function checkPermission($permissionName)
    {
        $user = auth()->user();
        if (!$user->hasAccessToPermission($permissionName)) {
            abort(403, 'Unauthorized');
        }
    }


    // ajax

    public function productDetails(Request $request, $id){
        $prices = DB::table('prices')->where('prices.product_id', $id)->join('stocks', 'prices.stock_id', 'stocks.id')->join('unitss', 'prices.unit_id', 'units.id')->select('stocks.product_quantity as product_quantity', 'prices.stock_id as stock_id', 'prices.unit_id as unit_id', 'prices.id as price_id', 'prices.product_price as product_price', 'units.name as name', 'units.short_name as short_name')->get();

        $options = '';
        foreach($prices as $price){
            $options[] =  `<option value="$price->product_price">$price->name | $price->short_name</option>`;
        }
        return response()->json([
            'prices' => $prices,
            'options' => $options,
        ]);
    }
}

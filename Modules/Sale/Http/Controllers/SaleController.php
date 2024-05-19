<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\Price;
use App\Models\ProductLoss;
use App\Models\Stock;
use Modules\Sale\DataTables\SalesDataTable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Http\Requests\StoreSaleRequest;
use Modules\Sale\Http\Requests\UpdateSaleRequest;

class SaleController extends Controller
{

    public function index(SalesDataTable $dataTable)
    {
        abort_if(Gate::denies('access_sales'), 403);

        return $dataTable->render('sale::index');
    }


    public function create()
    {
        // abort_if(Gate::denies('create_sales'), 403);
        $this->checkPermission('create_sales');
        Cart::instance('sale')->destroy();

        return view('sale::create');
    }


    public function store(StoreSaleRequest $request)
    {
        $this->checkPermission('create_sales');
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale = Sale::create([
                'date' => $request->date,
                // 'reference' => 'PSL',
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'tax_percentage' => $request->tax_percentage,
                // 'discount_percentage' => $request->discount_percentage,
                // 'shipping_amount' => $request->shipping_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'store_id' => auth()->user()->store->id
            ]);



            foreach ($request->cartDetails as $cartDetail) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cartDetail['productId'],
                    'quantity' => $cartDetail['quantity'],
                    'price_id' => $cartDetail['price_id'],
                    'store_id' => auth()->user()->store->id,
                    'stock_id' => $cartDetail['stock_id'], 
                    'unit_id' => $cartDetail['unit_id'], 
                ]);

                $product = Stock::findOrFail($cartDetail['stock_id']);
                $product->update([
                    'product_quantity' => $product->product_quantity - $cartDetail['quantity']
                ]);
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {
                SalePayment::create([
                    'sale_id' => $sale->id,
                    'amount' => $sale->paid_amount,
                    'date' => $request->date,
                    'store_id' => auth()->user()->store->id,
                    'payment_method' => $request->payment_method
                ]);
            }
           
        });

        toast('Sale Created!', 'success');

        // return redirect()->route('sales.index');
        return response()->json([
            'message' => 'success'
        ]);
    }


    public function show(Sale $sale)
    {
        // abort_if(Gate::denies('show_sales'), 403);
        $this->checkPermission('show_sales');
        $customer = Customer::findOrFail($sale->customer_id);
        $sales_details = SaleDetails::where('sale_details.sale_id', $sale->id)->join('units', 'sale_details.unit_id', 'units.id')->join('products', 'sale_details.product_id', 'products.id')->join('prices', 'sale_details.price_id', 'prices.id')->get();

        
        return view('sale::show', compact('sale', 'customer','sales_details'));
    }


   

    public function edit(Sale $sale)
    {
        // abort_if(Gate::denies('edit_sales'), 403);
        $this->checkPermission('edit_sales');
        // $sale_details = $sale->saleDetails;
        $sale_details = SaleDetails::join('products', 'sale_details.product_id', 'products.id')
            ->join('prices', 'sale_details.price_id', 'prices.id')
            ->join('units', 'sale_details.unit_id', 'units.id')
            ->join('stocks', 'sale_details.stock_id', 'stocks.id')
            ->where('sale_details.sale_id', $sale->id)
            ->get();


        Cart::instance('sale')->destroy();
        // echo $sale->id;
        $cart = Cart::instance('sale');

        foreach ($sale_details as $sale_detail) {
            $prices = Price::where('product_id', $sale_detail->product_id)->get();
            $priceOptions = [];

            $units = $sale_detail->unit_price;

            foreach ($prices as $price) {
                // Assuming each price has fields like 'price', 'start_date', 'end_date', etc.

                $priceOptions[] = [
                    'price'      => $price['product_price'],
                    'product_unit' => $price['product_unit'],
                    // Add any other fields you need
                ];
            }



            $cart->add([
                'id'      => $sale_detail->product_id,
                'name'    => $sale_detail->product_name,
                'qty'     => $sale_detail->quantity,
                'price'   => $sale_detail->product_price,
                'weight'  => 1,
                'options' => [
                    // 'product_discount' => $sale_detail->product_discount_amount,
                    // 'product_discount_type' => $sale_detail->product_discount_type,
                    'selected_quantity' => 1,
                    'sub_total'   => $sale_detail->sub_total,
                    'stock'       => $sale_detail->product_quantity,
                    'product_id'    => $sale_detail->product_id,
                    'unit'        => $sale_detail->name,
                    'unit_id'     => $sale_detail->unit_id,
                    'price_value'    => $sale_detail->product_price,
                    'price_id'       => $sale_detail->price_id,
                    'code'        => $sale_detail->product_code,
                    // 'product_tax' => $sale_detail->product_tax_amount,
                    'unit_price'  => $sale_detail->unit_price,
                    'prices'                => $priceOptions, // Add prices options here
                ]
            ]);
        }

        return view('sale::edit', compact('sale', 'sale_details'));
    }


    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $this->checkPermission('edit_sales');
        DB::transaction(function () use ($request, $sale) {

            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            // foreach ($sale->saleDetails as $sale_detail) {
            //     if ($sale->status == 'Shipped' || $sale->status == 'Completed') {
            //         $product = Product::findOrFail($sale_detail->product_id);
            //         $product->update([
            //             'product_quantity' => $product->product_quantity + $sale_detail->quantity
            //         ]);
            //     }
            //     $sale_detail->delete();
            // }

            $sale->update([
                'date' => $request->date,
                // 'reference' => $request->reference,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'tax_percentage' => $request->tax_percentage,
                // 'discount_percentage' => $request->discount_percentage,
                // 'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                // 'tax_amount' => Cart::instance('sale')->tax() * 100,
                // 'discount_amount' => Cart::instance('sale')->discount() * 100,
            ]);

            foreach ($request->cartDetails as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item['productId'],  
                    'quantity' => $cart_item['quantity'],
                    'price_id' => $cart_item['price_id'],
                    'unit_id' => $cart_item['unit_id'], 
                    'store_id' => auth()->user()->store->id,
                    'stock_id' => $cart_item['stock_id'], 
                ]);

                if ($request->status == 'Shipped' || $request->status == 'Completed') {
                    $product = Stock::findOrFail($cart_item['stock_id']);
                    $product->update([
                        'product_quantity' => $product->product_quantity - $cart_item['quantity']
                    ]);
                }
            }

            Cart::instance('sale')->destroy();
        });

        toast('Sale Updated!', 'info');

        return response()->json(['message' => 'success']);
    }


    public function destroy(Sale $sale)
    {
        // abort_if(Gate::denies('delete_sales'), 403);
        $this->checkPermission('delete_sales');
        $sale->delete();

        toast('Sale Deleted!', 'warning');

        return redirect()->route('sales.index');
    }
    protected function checkPermission($permissionName)
    {
        $user = auth()->user();
        if (!$user->hasAccessToPermission($permissionName)) {
            abort(403, 'Unauthorized');
        }
    }
}

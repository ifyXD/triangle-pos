<?php

namespace Modules\SalesReturn\Http\Controllers;

use App\Models\Price;
use App\Models\ProductLoss;
use App\Models\Stock;
use Modules\SalesReturn\DataTables\SaleReturnsDataTable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnDetail;
use Modules\SalesReturn\Entities\SaleReturnPayment;
use Modules\SalesReturn\Http\Requests\StoreSaleReturnRequest;
use Modules\SalesReturn\Http\Requests\UpdateSaleReturnRequest;
use Modules\Setting\Entities\Unit;

class SalesReturnController extends Controller
{
    protected function checkPermission($permissionName)
    {
        $user = auth()->user();
        if (!$user->hasAccessToPermission($permissionName)) {
            abort(403, 'Unauthorized');
        }
    }

    public function index(SaleReturnsDataTable $dataTable)
    {
        abort_if(Gate::denies('access_sale_returns'), 403);
        $saleReturnIds = SaleReturnDetail::select('sale_return_id')->distinct()->pluck('sale_return_id');

        SaleReturn::whereNotIn('id', $saleReturnIds)->delete();
        return $dataTable->render('salesreturn::index');
    }


    public function create()
    {
        // abort_if(Gate::denies('create_sale_returns'), 403);
        $this->checkPermission('create_sale_returns');

        Cart::instance('sale_return')->destroy();

        return view('salesreturn::create');
    }


    public function store(StoreSaleReturnRequest $request)
    {
        $this->checkPermission('create_sale_returns');
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale_return = SaleReturn::create([
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                // 'tax_percentage' => $request->tax_percentage,
                // 'discount_percentage' => $request->discount_percentage,
                // 'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'return_status' => $request->return_status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                // 'tax_amount' => Cart::instance('sale_return')->tax() * 100,
                // 'discount_amount' => Cart::instance('sale_return')->discount() * 100,
                'store_id' => auth()->user()->store->id,
            ]);


            foreach ($request->cartDetails as $cartDetail) {

                SaleReturnDetail::create([
                    'sale_return_id' => $sale_return->id,
                    'product_id' => $cartDetail['productId'],
                    'quantity' => $cartDetail['quantity'],
                    'price_id' => $cartDetail['price_id'],
                    'unit_id' => $cartDetail['unit_id'],
                    'store_id' => auth()->user()->store->id,
                ]);




                if ($request->return_status == 'loss') {
                    ProductLoss::create([
                        'sale_return_id' => $sale_return->id,
                        'product_id' => $cartDetail['productId'],
                        'stock_id' => $cartDetail['stock_id'],
                        'store_id' => auth()->user()->store->id,
                    ]);
                } else {
                    $product = Stock::findOrFail($cartDetail['stock_id']);
                    $product->update([
                        'product_quantity' => $product->product_quantity + $cartDetail['quantity']
                    ]);
                }
            }

            Cart::instance('sale_return')->destroy();

            if ($sale_return->paid_amount > 0) {
                SaleReturnPayment::create([
                    'date' => $request->date,
                    'amount' => $sale_return->paid_amount,
                    'sale_return_id' => $sale_return->id,
                    'payment_method' => $request->payment_method,
                    'store_id' => auth()->user()->store->id,
                ]);
            }
        });

        toast('Sale Return Created!', 'success');

        // return redirect()->route('sale-returns.index');
        return response()->json([
            'message' => 'success'
        ]);
    }


    public function show(SaleReturn $sale_return)
    {
        // abort_if(Gate::denies('show_sale_returns'), 403);
        $this->checkPermission('show_sale_returns');

        $customer = Customer::findOrFail($sale_return->customer_id);

        return view('salesreturn::show', compact('sale_return', 'customer'));
    }


    public function edit(SaleReturn $sale_return)
    {
        // abort_if(Gate::denies('edit_sale_returns'), 403);
        $this->checkPermission('edit_sale_returns');
        $sale_return_details = SaleReturnDetail::join('products', 'sale_return_details.product_id', 'products.id')
            ->join('prices', 'sale_return_details.price_id', 'prices.id')
            ->join('units', 'sale_return_details.unit_id', 'units.id')
            ->join('stocks', 'sale_return_details.stock_id', 'stocks.id')
            ->where('sale_return_details.sale_return_id', $sale_return->id)
            ->select('sale_return_details.id as detail_id', 'sale_return_details.quantity', 'products.*', 'stocks.*', 'prices.*', 'prices.id as price_id', 'products.id as product_id', 'units.*')
            ->get();


        Cart::instance('sale_return')->destroy();

        $cart = Cart::instance('sale_return');

        foreach ($sale_return_details as $sale_return_detail) {

            $prices = Price::where('product_id', $sale_return_detail->product_id)->get();
            $priceOptions = [];

            $units = $sale_return_detail->unit_price;

            foreach ($prices as $price) {
                // Assuming each price has fields like 'price', 'start_date', 'end_date', etc.

                $priceOptions[] = [
                    'price'      => $price['product_price'],
                    'product_unit' => $price['product_unit'],
                    // Add any other fields you need
                ];
            }


            $cart->add([
                'id'      => $sale_return_detail->id,
                'name'    => $sale_return_detail->product_name,
                'qty'     => $sale_return_detail->quantity,
                'price'   => $sale_return_detail->product_price,
                'weight'  => 1,
                'options' => [
                    // 'product_discount' => $sale_return_detail->product_discount_amount,
                    // 'product_discount_type' => $sale_return_detail->product_discount_type,
                    'selected_quantity' => 1,
                    'sub_total'   => $sale_return_detail->product_price * $sale_return_detail->product_quantity,
                    'stock'       => $sale_return_detail->product_quantity,
                    'product_id'    => $sale_return_detail->product_id,
                    'unit'        => $sale_return_detail->name,
                    'unit_id'     => $sale_return_detail->unit_id,
                    'price_value'    => $sale_return_detail->product_price,
                    'price_id'       => $sale_return_detail->price_id,
                    'sale_id' => $sale_return_detail->detail_id,
                    // 'product_tax' => $sale_return_detail->product_tax_amount,
                    'unit_price'  => $sale_return_detail->unit_price,
                    'prices'                => $priceOptions, // Add prices options here
                ]
            ]);
        }

        return view('salesreturn::edit', compact('sale_return'));
    }


    public function update(UpdateSaleReturnRequest $request, SaleReturn $sale_return)
    {
        $this->checkPermission('edit_sale_returns');
        DB::transaction(function () use ($request, $sale_return) {
            try {
                $due_amount = $request->total_amount - $request->paid_amount;

                if ($due_amount == $request->total_amount) {
                    $payment_status = 'Unpaid';
                } elseif ($due_amount > 0) {
                    $payment_status = 'Partial';
                } else {
                    $payment_status = 'Paid';
                }

                // Update sale return record
                $sale_return->update([
                    'date' => $request->date,
                    'customer_id' => $request->customer_id,
                    'customer_name' => Customer::findOrFail($request->customer_id)->customer_name,
                    'paid_amount' => $request->paid_amount,
                    'total_amount' => $request->total_amount,
                    'due_amount' => $due_amount,
                    'status' => $request->status,
                    'payment_status' => $payment_status,
                    'payment_method' => $request->payment_method,
                    'note' => $request->note,
                ]);

                foreach ($request->cartDetails as $cart_item) {

                    // SaleReturnDetail::where('sale_return_id', $sale_return->id)->delete();

                    // Check the existence of the foreign key references
                    if (
                        !Product::find($cart_item['productId']) ||
                        !Price::find($cart_item['price_id']) ||
                        !Unit::find($cart_item['unit_id']) ||
                        !Stock::find($cart_item['stock_id'])
                    ) {
                        throw new \Exception('One or more related resources not found.');
                    }

                    // Create sale return detail record
                    // SaleReturnDetail::find($cart_item['sale_id'])->update([
                    //     // 'sale_return_id' => $sale_return->id,
                    //     // 'product_id' => $cart_item['productId'],
                    //     'quantity' => $cart_item['quantity'],
                    //     // 'price_id' => $cart_item['price_id'],
                    //     // 'store_id' => auth()->user()->store->id,
                    //     // 'unit_id' => $cart_item['unit_id'],
                    //     // 'stock_id' => $cart_item['stock_id'],
                    // ]);

                    // Update product quantity in stock if status is 'Shipped' or 'Completed'
                    // if (in_array($request->status, ['Shipped', 'Completed'])) {
                    //     $stock = Stock::find($cart_item['stock_id']);
                    //     $stock->update([
                    //         'product_quantity' => $stock->product_quantity - $cart_item['quantity']
                    //     ]);
                    // }
                }

                // Destroy sale return cart instance
                Cart::instance('sale_return')->destroy();

                toast('Sale Return Updated!', 'info');
                return response()->json(['message' => 'success']);
            } catch (\Exception $e) {
                // Handle the exception and return a meaningful response
                return response()->json(['error' => $e->getMessage()], 400);
            }
        });
        foreach ($request->cartDetails as $cart_item) {
            SaleReturnDetail::find($cart_item['sale_id'])->update([
                // 'sale_return_id' => $sale_return->id,
                // 'product_id' => $cart_item['productId'],
                'quantity' => $cart_item['quantity'],
                // 'price_id' => $cart_item['price_id'],
                // 'store_id' => auth()->user()->store->id,
                // 'unit_id' => $cart_item['unit_id'],
                // 'stock_id' => $cart_item['stock_id'],
            ]);
        }
    }


    public function destroy(SaleReturn $sale_return)
    {
        // abort_if(Gate::denies('delete_sale_returns'), 403);
        $this->checkPermission('delete_sale_returns');

        $sale_return->delete();

        toast('Sale Return Deleted!', 'warning');

        return redirect()->route('sale-returns.index');
    }
}

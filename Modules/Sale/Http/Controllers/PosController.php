<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\Price;
use App\Models\Stock;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Http\Requests\StorePosSaleRequest;

class PosController extends Controller
{
    protected function checkPermission($permissionName)
    {
        $user = auth()->user();
        if (!$user->hasAccessToPermission($permissionName)) {
            abort(403, 'Unauthorized');
        }
    }
    public function index()
    {
        $this->checkPermission('create_pos_sales');

        Cart::instance('sale')->destroy();

        $customers = Customer::where('user_id', auth()->user()->id)->get();
        $product_categories = Category::all();

        return view('sale::pos.index', compact('product_categories', 'customers'));
    }


    public function store(StorePosSaleRequest $request)
    {
        $sale_id = 0;
       
        DB::transaction(function () use ($request, &$sale_id) {
            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale = Sale::create([
                'date' => now()->format('Y-m-d'),
                // 'reference' => 'PSL',
                'customer_id' => $request->customer_id,
                'customer_name' => Customer::findOrFail($request->customer_id)->customer_name, 
                'paid_amount' => $request->paid_amount * 100,
                'due_amount' => $due_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'store_id' => auth()->user()->store->id,
            ]);
        
            foreach ($request->cartDetails as $cartDetail) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cartDetail['productId'], 
                    'quantity' => $cartDetail['quantity'],
                    'price_id' => $cartDetail['price_id'], 
                    'store_id' => auth()->user()->store->id,
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
                    'date' => now()->format('Y-m-d'),
                    'store_id' => auth()->user()->store->id,
                    'payment_method' => $request->payment_method
                ]);
            }
            $sale_id = $sale->id;
        });

        toast('POS Sale Created!', 'success');

        // return redirect()->route('sales.index');
        return response()->json([
            'message' => 'success',
            'id' => $sale_id,
        ]);
    }
}

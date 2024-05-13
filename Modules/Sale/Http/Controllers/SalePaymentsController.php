<?php

namespace Modules\Sale\Http\Controllers;

use App\Models\Stock;
use Gloudemans\Shoppingcart\Facades\Cart;
use Modules\Sale\DataTables\SalePaymentsDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Customer;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnDetail;
use Modules\SalesReturn\Entities\SaleReturnPayment;

class SalePaymentsController extends Controller
{
    protected function checkPermission($permissionName)
    {
        $user = auth()->user();
        if (!$user->hasAccessToPermission($permissionName)) {
            abort(403, 'Unauthorized');
        }
    }
    public function index($sale_id, SalePaymentsDataTable $dataTable)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_payments');

        $sale = Sale::findOrFail($sale_id);

        return $dataTable->render('sale::payments.index', compact('sale'));
    }


    public function create($sale_id)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_payments');

        $sale = Sale::findOrFail($sale_id);

        return view('sale::payments.create', compact('sale'));
    }


    public function store(Request $request)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_payments');

        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'sale_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request) {
            SalePayment::create([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'sale_id' => $request->sale_id,
                'payment_method' => $request->payment_method,
                'user_id' => auth()->user()->id
            ]);

            $sale = Sale::findOrFail($request->sale_id);

            $due_amount = $sale->due_amount - $request->amount;

            if ($due_amount == $sale->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale->update([
                'paid_amount' => ($sale->paid_amount + $request->amount) * 100,
                'due_amount' => $due_amount * 100,
                'payment_status' => $payment_status
            ]);
        });

        toast('Sale Payment Created!', 'success');

        return redirect()->route('sales.index');
    }


    public function edit($sale_id, SalePayment $salePayment)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_payments');

        $sale = Sale::findOrFail($sale_id);

        return view('sale::payments.edit', compact('salePayment', 'sale'));
    }


    public function update(Request $request, SalePayment $salePayment)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_payments');
        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'sale_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request, $salePayment) {
            $sale = $salePayment->sale;

            $due_amount = ($sale->due_amount + $salePayment->amount) - $request->amount;

            if ($due_amount == $sale->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale->update([
                'paid_amount' => (($sale->paid_amount - $salePayment->amount) + $request->amount) * 100,
                'due_amount' => $due_amount * 100,
                'payment_status' => $payment_status
            ]);

            $salePayment->update([
                'date' => $request->date,
                'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'sale_id' => $request->sale_id,
                'payment_method' => $request->payment_method
            ]);
        });

        toast('Sale Payment Updated!', 'info');

        return redirect()->route('sales.index');
    }


    public function destroy(SalePayment $salePayment)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_payments');

        $salePayment->delete();

        toast('Sale Payment Deleted!', 'warning');

        return redirect()->route('sales.index');
    }
    public function dispatch($id)
    {
        // abort_if(Gate::denies('access_sale_payments'), 403);
        $this->checkPermission('access_sale_returns');
        $sale = Sale::findOrfail($id);
        $sale_details = SaleDetails::where('sale_id', $id)->get();

        $sale_return = SaleReturn::create([
            'date' => now()->format('Y-m-d'),
            'customer_id' => $sale->customer_id,
            'customer_name' => Customer::findOrFail($sale->customer_id)->customer_name,
            'total_amount' => $sale->total_amount,
            'paid_amount' => $sale->paid_amount,
            'due_amount' => $sale->due_amount,
            'status' => $sale->status,
            'payment_status' => $sale->payment_status,
            'payment_method' => $sale->payment_method,
            'note' => $sale->note,
            'store_id' => auth()->user()->store->id,
        ]);

        foreach ($sale_details as $cartDetail) {
            SaleReturnDetail::create([
                'sale_return_id' => $sale_return->id,
                'product_id' => $cartDetail->product_id,
                'quantity' => $cartDetail->quantity,
                'price_id' => $cartDetail->price_id,
                'unit_id' => $cartDetail->unit_id,
                'stock_id' => $cartDetail->stock_id,
                'store_id' => auth()->user()->store->id,
            ]);

            // $stock = Stock::find($cartDetail->stock_id);
            // $t_qty = $cartDetail->quantity+$stock->product_quantity;
            // $stock->update([
            //     'product_quantity' => $t_qty,
            // ]);
        }

        Cart::instance('sale_return')->destroy();

        if ($sale_return->paid_amount > 0) {
            SaleReturnPayment::create([
                'date' => now()->format('Y-m-d'),
                'amount' => $sale->paid_amount,
                'sale_return_id' => $sale_return->id,
                'payment_method' => $sale->payment_method,
                'store_id' => auth()->user()->store->id,
            ]);
        }


        Sale::findOrFail($id)->delete();

        toast('Sale Return Created!', 'success');

        return redirect('sale-returns');
    }
}

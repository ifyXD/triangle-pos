<?php

namespace Modules\SalesReturn\Http\Controllers;

use App\Models\ProductLoss;
use App\Models\Stock;
use Modules\SalesReturn\DataTables\SaleReturnPaymentsDataTable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnDetail;
use Modules\SalesReturn\Entities\SaleReturnPayment;

class SaleReturnPaymentsController extends Controller
{

    public function index($sale_return_id, SaleReturnPaymentsDataTable $dataTable)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $sale_return = SaleReturn::findOrFail($sale_return_id);

        return $dataTable->render('salesreturn::payments.index', compact('sale_return'));
    }


    public function create($sale_return_id)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $sale_return = SaleReturn::findOrFail($sale_return_id);

        return view('salesreturn::payments.create', compact('sale_return'));
    }


    public function store(Request $request)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $request->validate([
            'date' => 'required|date',
            // 'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'sale_return_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request) {
            SaleReturnPayment::create([
                'date' => $request->date,
                // 'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'sale_return_id' => $request->sale_return_id,
                'payment_method' => $request->payment_method,
                'user_id' => auth()->user()->id,
            ]);

            $sale_return = SaleReturn::findOrFail($request->sale_return_id);

            $due_amount = $sale_return->due_amount - $request->amount;

            if ($due_amount == $sale_return->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale_return->update([
                'paid_amount' => ($sale_return->paid_amount + $request->amount) * 100,
                'due_amount' => $due_amount * 100,
                'payment_status' => $payment_status
            ]);
        });

        toast('Sale Return Payment Created!', 'success');

        return redirect()->route('sale-returns.index');
    }


    public function edit($sale_return_id, SaleReturnPayment $saleReturnPayment)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $sale_return = SaleReturn::findOrFail($sale_return_id);

        return view('salesreturn::payments.edit', compact('saleReturnPayment', 'sale_return'));
    }


    public function update(Request $request, SaleReturnPayment $saleReturnPayment)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $request->validate([
            'date' => 'required|date',
            // 'reference' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'note' => 'nullable|string|max:1000',
            'sale_return_id' => 'required',
            'payment_method' => 'required|string|max:255'
        ]);

        DB::transaction(function () use ($request, $saleReturnPayment) {
            $sale_return = $saleReturnPayment->saleReturn;

            $due_amount = ($sale_return->due_amount + $saleReturnPayment->amount) - $request->amount;

            if ($due_amount == $sale_return->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            $sale_return->update([
                'paid_amount' => (($sale_return->paid_amount - $saleReturnPayment->amount) + $request->amount) * 100,
                'due_amount' => $due_amount * 100,
                'payment_status' => $payment_status
            ]);

            $saleReturnPayment->update([
                'date' => $request->date,
                // 'reference' => $request->reference,
                'amount' => $request->amount,
                'note' => $request->note,
                'sale_return_id' => $request->sale_return_id,
                'payment_method' => $request->payment_method
            ]);
        });

        toast('Sale Return Payment Updated!', 'info');

        return redirect()->route('sale-returns.index');
    }


    public function destroy(SaleReturnPayment $saleReturnPayment)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $saleReturnPayment->delete();

        toast('Sale Return Payment Deleted!', 'warning');

        return redirect()->route('sale-returns.index');
    }
    public function return_Stock($id)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $sale_return_details = SaleReturnDetail::find($id);

        $stock = Stock::find($sale_return_details->stock_id);
        $qty = $stock->product_quantity + $sale_return_details->quantity;
        $stock->update([
            'product_quantity' => $qty,

        ]);

        $sale_return_details->update([
            'return_status' => 'return'
        ]);

        toast('Stock/s Return Successfully!', 'success');

        return redirect()->back();
    }
    public function create_product_loss($id)
    {
        abort_if(Gate::denies('access_sale_return_payments'), 403);

        $sale_return_details = SaleReturnDetail::find($id);

        ProductLoss::create([
            'sale_return_id' => $id,
            'product_id' => $sale_return_details->product_id,
            'stock_id' => $sale_return_details->stock_id,
            'store_id' => auth()->user()->store->id,
        ]);

        SaleReturnDetail::findorFail($id)->update([
            'return_status' => 'loss'
        ]);
        toast('Saved as Product Loss!', 'success');

        return redirect()->route('sale-returns.index');
    }
}

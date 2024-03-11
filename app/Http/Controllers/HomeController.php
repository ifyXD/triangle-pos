<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\Expense;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\PurchasesReturn\Entities\PurchaseReturn;
use Modules\PurchasesReturn\Entities\PurchaseReturnPayment;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SalePayment;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnPayment;

class HomeController extends Controller
{

    public function index()
    { 

        $user = auth()->user();

        $salesQuery = Sale::completed();
        $saleReturnsQuery = SaleReturn::completed();
        $purchaseReturnsQuery = PurchaseReturn::completed();

        // If the user is not a "Super Admin," filter the queries by user_id
        if (!$user->hasRole('Super Admin')) {
            $salesQuery->where('user_id', $user->id);
            $saleReturnsQuery->where('user_id', $user->id);
            $purchaseReturnsQuery->where('user_id', $user->id);
        }

        $sales = $salesQuery->sum('total_amount');
        $saleReturns = $saleReturnsQuery->sum('total_amount');
        $purchaseReturns = $purchaseReturnsQuery->sum('total_amount');

        $product_costs = 0;

        foreach ($salesQuery->with('saleDetails')->get() as $sale) {
            foreach ($sale->saleDetails as $saleDetail) {
                if (!is_null($saleDetail->product)) {
                    $product_costs += $saleDetail->product->product_cost * $saleDetail->quantity;
                }
            }
        }

        $revenue = ($sales - $saleReturns) / 100;
        $profit = $revenue - $product_costs;

        return view('home', [
            'revenue' => $revenue,
            'sale_returns' => $saleReturns / 100,
            'purchase_returns' => $purchaseReturns / 100,
            'profit' => $profit,
        ]);
    }


    public function currentMonthChart()
    {

        abort_if(!request()->ajax(), 404);

        $user = auth()->user();

        if (!$user->hasRole('Super Admin')) {
            $currentMonthSales = Sale::where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
            $currentMonthPurchases = Purchase::where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
            $currentMonthExpenses = Expense::whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('amount') / 100;
        } else {
            $currentMonthSales = Sale::where('user_id', $user->id)->where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
            $currentMonthPurchases = Purchase::where('user_id', $user->id)->where('status', 'Completed')->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('total_amount') / 100;
            $currentMonthExpenses = Expense::where('user_id', $user->id)->whereMonth('date', date('m'))
                ->whereYear('date', date('Y'))
                ->sum('amount') / 100;
        }



        return response()->json([
            'sales'     => $currentMonthSales,
            'purchases' => $currentMonthPurchases,
            'expenses'  => $currentMonthExpenses
        ]);
    }


    public function salesPurchasesChart()
    {
        abort_if(!request()->ajax(), 404);



        $sales = $this->salesChartData();
        $purchases = $this->purchasesChartData();

        return response()->json(['sales' => $sales, 'purchases' => $purchases]);
    }


    public function paymentChart()
    {
        abort_if(!request()->ajax(), 404);

        $dates = collect();
        foreach (range(-11, 0) as $i) {
            $date = Carbon::now()->addMonths($i)->format('m-Y');
            $dates->put($date, 0);
        }


        $date_range = Carbon::today()->subYear()->format('Y-m-d');

        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            $sale_payments = SalePayment::where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $sale_return_payments = SaleReturnPayment::where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $purchase_payments = PurchasePayment::where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $purchase_return_payments = PurchaseReturnPayment::where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $expenses = Expense::where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');
        } else {

            $sale_payments = SalePayment::where('user_id', $user->id)->where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $sale_return_payments = SaleReturnPayment::where('user_id', $user->id)->where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $purchase_payments = PurchasePayment::where('user_id', $user->id)->where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $purchase_return_payments = PurchaseReturnPayment::where('user_id', $user->id)->where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $expenses = Expense::where('user_id', $user->id)->where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');
        }



        $payment_received = array_merge_numeric_values($sale_payments, $purchase_return_payments);
        $payment_sent = array_merge_numeric_values($purchase_payments, $sale_return_payments, $expenses);

        $dates_received = $dates->merge($payment_received);
        $dates_sent = $dates->merge($payment_sent);

        $received_payments = [];
        $sent_payments = [];
        $months = [];

        foreach ($dates_received as $key => $value) {
            $received_payments[] = $value;
            $months[] = $key;
        }

        foreach ($dates_sent as $key => $value) {
            $sent_payments[] = $value;
        }

        return response()->json([
            'payment_sent' => $sent_payments,
            'payment_received' => $received_payments,
            'months' => $months,
        ]);
    }

    public function salesChartData()
    {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('d-m-y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subDays(6);


        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            $sales = Sale::where('status', 'Completed')
                ->where('date', '>=', $date_range)
                ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
                ->orderBy('date')
                ->get([
                    DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                    DB::raw('SUM(total_amount) AS count'),
                ])
                ->pluck('count', 'date');
        } else {
            $sales = Sale::where('user_id', $user->id)->where('status', 'Completed')
                ->where('date', '>=', $date_range)
                ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
                ->orderBy('date')
                ->get([
                    DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                    DB::raw('SUM(total_amount) AS count'),
                ])
                ->pluck('count', 'date');
        }

        // If not "Super Admin," apply the original condition 
        $dates = $dates->merge($sales);

        $data = [];
        $days = [];
        foreach ($dates as $key => $value) {
            $data[] = $value / 100;
            $days[] = $key;
        }

        return response()->json(['data' => $data, 'days' => $days]);
    }


    public function purchasesChartData()
    {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('d-m-y');
            $dates->put($date, 0);
        }

        $date_range = Carbon::today()->subDays(6);

        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            $purchases = Purchase::where('status', 'Completed')
                ->where('date', '>=', $date_range)
                ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
                ->orderBy('date')
                ->get([
                    DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                    DB::raw('SUM(total_amount) AS count'),
                ])
                ->pluck('count', 'date');
        } else {
            $purchases = Purchase::where('user_id', $user->id)->where('status', 'Completed')
                ->where('date', '>=', $date_range)
                ->groupBy(DB::raw("DATE_FORMAT(date,'%d-%m-%y')"))
                ->orderBy('date')
                ->get([
                    DB::raw(DB::raw("DATE_FORMAT(date,'%d-%m-%y') as date")),
                    DB::raw('SUM(total_amount) AS count'),
                ])
                ->pluck('count', 'date');
        }



        $dates = $dates->merge($purchases);

        $data = [];
        $days = [];
        foreach ($dates as $key => $value) {
            $data[] = $value / 100;
            $days[] = $key;
        }

        return response()->json(['data' => $data, 'days' => $days]);
    }
    public function requirements(){
       return view('auth.color-palette');
    }
}

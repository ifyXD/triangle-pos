<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
use Modules\Setting\Entities\Setting;

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


        // dd($salesQuery);
        return view('home', [
            'revenue' => $revenue,
            'sale_returns' => $saleReturns / 100,
            'purchase_returns' => $purchaseReturns / 100,
            'profit' => $profit,
        ]);
    }
    public function storename()
    {
        return view('auth.storename');
    }
    public function permission()
    {
        return view('auth.permission');
    }
    public function colorpallete()
    {
        return view('auth.color-palette');
    }
    public function updaterequirements(Request $request)
    {
        $redirect = '';
        if ($request->requestdata === 'storename') {
            Setting::updateOrCreate(
                ['user_id' => auth()->user()->id], // Use the user's ID
                ['company_name' => $request->storename]
            );

            User::where('id', auth()->id())->update(['reg_requirements' => 2]);

            $redirect = redirect()->route('registration.requirements-permission');
        }
        return $redirect;
    }
    public function withPermission(Request $request)
    {
        $user = auth()->user();

        // Sync permissions
        $permissions = $request->input('permissions', []);

        // Save permissions in user_permissions table
        foreach ($permissions as $permissionId) {
            // Create or update the record in the user_permissions table
            UserPermission::updateOrCreate(
                ['user_id' => $user->id, 'permission_id' => $permissionId],
                ['status' => 'true'] // Set status to true since the permission is enabled
            );
        }

        // Update registration requirements
        $user->reg_requirements = 3;
        $user->save();

        // Logout if the user ID does not match the authenticated user's ID
        // if ($user->id != $request->id) {
        //     Auth::logout();
        //     return redirect()->route('register');
        // }

        // Set status to false for permissions not present in the submitted data 

        return response()->json(['message' => 'Permissions saved successfully'], 200);
    }

    public function withPermission_update(Request $request)
    {

        $user = auth()->user();

        // Sync permissions
        $permissions = $request->input('permissions', []);


        // Save permissions in user_permissions table
        foreach ($permissions as  $permission) {
            // Create or update the record in the user_permissions table
            UserPermission::updateOrCreate(
                ['user_id' => $user->id, 'permission_id' => $permission['permission_id']],
                ['status' => $permission['status']] // Set status to true since the permission is enabled
            );
        }

        if (auth()->user()->id != $request->id) {
            Auth::logout();
            return redirect()->route('register');
        }
        toast('Settings Updated!', 'info');
        // Set status to false for permissions not present in the submitted data 
        return response()->json(['message' => 'Permissions saved successfully'], 200);
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

    public function updateSession(Request $request)
    {
        if (auth()->user()->id != $request->id) {
            Auth::logout();
            return redirect()->route('register');
        } else {
            $userId = auth()->id(); // Get the authenticated user's ID

            // Construct session keys with a prefix using the user's unique identifier
            $selectedElementKey = 'selectedElement_' . $userId;
            $storenameKey = 'storename_' . $userId;

            $selectedElement = $request->input('selectedElement');
            $storename = $request->input('storename');

            // Check if session variables are not set and initialize them
            if (!session()->has($selectedElementKey)) {
                session([$selectedElementKey => 'first']);
            }

            if (!session()->has($storenameKey)) {
                session([$storenameKey => '']);
            }

            if ($storename !== null) {
                // Save in settings table using updateOrCreate
                Setting::updateOrCreate(
                    ['user_id' => $userId], // Use the user's ID
                    ['company_name' => $storename]
                );
            }

            // Update session variables with the user-specific keys
            session([$selectedElementKey => $selectedElement]);
            session([$storenameKey => $storename]);
        }

        // You can return a response if necessary
        return response()->json(['success' => true]);
    }



    public function update_requirements(Request $request)
    {

        $user_id = auth()->user()->id;
        User::where('id', $user_id)->update(['reg_requirements' => null]);


        $color_palette = $request->first . ',' . $request->second . ',' . $request->third;
        ThemeSetting::updateOrCreate(
            ['user_id' => $user_id],
            ['color_palette' => $color_palette]
        );

        toast('Settings Updated!', 'info');

        return response()->json([
            'message' => $request->first
        ]);
    }
    public function userlist()
    {
        $uselist = DB::select("CALL getUsers()");
        return response()->json($uselist);
    }
}

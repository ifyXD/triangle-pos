<?php

namespace App\Http\Controllers;

use App\Models\Figures\Product;
use App\Models\Stock;
use App\Models\Store;
use App\Models\ThemeSetting;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\Expense;
use Modules\Product\Entities\Category;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\PurchasesReturn\Entities\PurchaseReturn;
use Modules\PurchasesReturn\Entities\PurchaseReturnPayment;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\SalesReturn\Entities\SaleReturn;
use Modules\SalesReturn\Entities\SaleReturnPayment;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Entities\Unit;

class HomeController extends Controller
{
    public $search_category = '';


    public function index(Request $request)
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        $this->search_category = $request->category_id ?? 1;
        $user = auth()->user();

        $salesQuery = Sale::completed();

        $saleReturnsQuery = SaleReturn::completed();
        $purchaseReturnsQuery = PurchaseReturn::completed();

        // If the user is not a "Super Admin," filter the queries by user

        $sales = $salesQuery->sum('total_amount');

        $saleReturns = $saleReturnsQuery->sum('total_amount');

        // $purchaseReturns = $purchaseReturnsQuery->sum('total_amount');

        $product_costs = 0;

        foreach ($salesQuery->with('saleDetails')->get() as $sale) {
            foreach ($sale->saleDetails as $saleDetail) {
                if (!is_null($saleDetail->product)) {
                    $product_costs += $saleDetail->product->product_cost * $saleDetail->quantity;
                }
            }
        }

        $revenue = ($sales - $saleReturns);
        $profit = $revenue - $product_costs;


        $firstDayOfMonth = Carbon::now()->startOfMonth();

        // Get the last day of the current month
        $lastDayOfMonth = Carbon::now()->endOfMonth();

        // Fetch sales data for the current month
        $sales = auth()->user()->hasRole('Super Admin') ? SaleDetails::selectRaw('products.product_name, SUM(prices.product_price * sale_details.quantity) AS total')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('prices', 'sale_details.price_id', '=', 'prices.id')
            ->whereBetween('sale_details.created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->groupBy('products.product_name')
            ->get() :
            SaleDetails::selectRaw('products.product_name, SUM(prices.product_price * sale_details.quantity) AS total')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('prices', 'sale_details.price_id', '=', 'prices.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->where('sale_details.store_id', auth()->user()->store->id)
            ->whereBetween('sale_details.created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('categories.id', 'like', '%' . $this->search_category . '%')
            ->groupBy('products.product_name')
            ->get();

        // Extract product names and totals
        $products = $sales->pluck('product_name')->toArray();
        $totals = $sales->pluck('total')->toArray();
        // dd($salesQuery);

        $total_products = count(Product::all());

        $low_quantity_products = auth()->user()->hasRole('Super Admin') ? Stock::whereColumn('product_quantity', '<=', 'product_stock_alert')
            ->get() :  Stock::where('store_id', auth()->user()->store->id)
            ->whereColumn('product_quantity', '<=', 'product_stock_alert')
            ->get();
        $out_of_stocks = auth()->user()->hasRole('Super Admin') ? Stock::where('product_quantity', 0)
            ->get() : Stock::where('store_id', auth()->user()->store->id)
            ->where('product_quantity', 0)
            ->get();

        $users = count(User::where('id', '!=',auth()->user()->id)->get());
        return view('home', [
            'revenue' => $revenue,
            'sale_returns' => $saleReturns / 100,
            // 'purchase_returns' => $purchaseReturns / 100,
            'profit' => $profit,
            'products' => $products,
            'totals' => $totals,
            'total_products' => $total_products,
            'low_quantity_products' => $low_quantity_products,
            'out_of_stocks' => $out_of_stocks,
            'categories' => $categories,
            'users' => $users,
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
            // First, define the validation rules
            $rules = [
                'storename' => 'required', // 'required' rule makes the field mandatory
            ];

            // Validate the request data
            $request->validate($rules);

            // Proceed with the updateOrCreate method
            Store::updateOrCreate(
                ['user_id' => auth()->user()->id], // Use the user's ID
                ['store_name' => $request->storename]
            );


            User::where('id', auth()->id())->update(['reg_requirements' => 2]);

            $units = [
                [
                    'name' => 'Piece',
                    'short_name' => 'pc',
                    'operator' => '*',
                    'operation_value' => 1,
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Gram',
                    'short_name' => 'g',
                    'operator' => '*',
                    'operation_value' => 1,
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Kilogram',
                    'short_name' => 'kg',
                    'operator' => '*',
                    'operation_value' => 1000, // 1 kg = 1000 g
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Metric ton',
                    'short_name' => 't',
                    'operator' => '*',
                    'operation_value' => 1000000, // 1 t = 1000 kg = 1000000 g
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Pound',
                    'short_name' => 'lb',
                    'operator' => '*',
                    'operation_value' => 453.592, // 1 lb = 453.592 g
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Ounce',
                    'short_name' => 'oz',
                    'operator' => '*',
                    'operation_value' => 28.3495, // 1 oz = 28.3495 g
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Liter',
                    'short_name' => 'L',
                    'operator' => '*',
                    'operation_value' => 1000, // 1 L = 1000 mL
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Milliliter',
                    'short_name' => 'ml',
                    'operator' => '*',
                    'operation_value' => 1,
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Cubic meter',
                    'short_name' => 'm³',
                    'operator' => '*',
                    'operation_value' => 1000000, // 1 m³ = 1000 L = 1000000 mL
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Cubic centimeter',
                    'short_name' => 'cm³ or cc',
                    'operator' => '*',
                    'operation_value' => 1,
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Gallon',
                    'short_name' => 'gal',
                    'operator' => '*',
                    'operation_value' => 3785.41, // 1 gal = 3785.41 mL
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Quart',
                    'short_name' => 'qt',
                    'operator' => '*',
                    'operation_value' => 946.353, // 1 qt = 946.353 mL
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Meter',
                    'short_name' => 'm',
                    'operator' => '*',
                    'operation_value' => 1,
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Centimeter',
                    'short_name' => 'cm',
                    'operator' => '*',
                    'operation_value' => 0.01, // 1 cm = 0.01 m
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Kilometer',
                    'short_name' => 'km',
                    'operator' => '*',
                    'operation_value' => 1000, // 1 km = 1000 m
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Inch',
                    'short_name' => 'in',
                    'operator' => '*',
                    'operation_value' => 0.0254, // 1 in = 0.0254 m
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Foot',
                    'short_name' => 'ft',
                    'operator' => '*',
                    'operation_value' => 0.3048, // 1 ft = 0.3048 m
                    'store_id' => auth()->user()->store->id
                ],
                [
                    'name' => 'Yard',
                    'short_name' => 'yd',
                    'operator' => '*',
                    'operation_value' => 0.9144, // 1 yd = 0.9144 m
                    'store_id' => auth()->user()->store->id
                ],
            ];

            // Loop through the unit data and create records
            foreach ($units as $unit) {
                Unit::create($unit);
            }

            $redirect = redirect()->route('registration.requirements-permission');
        }
        return $redirect;
    }
    public function withPermission(Request $request)
    {
        $user_id = auth()->id(); // Assuming you're using Laravel's built-in authentication
        $user = auth()->user();
        // Get the checked and unchecked permission arrays from the request
        $checked_permissions = $request->input('checked_permissions', []);
        $unchecked_permissions = $request->input('unchecked_permissions', []);

        // Set the status for unchecked permissions to 'false' and for checked permissions to 'true'
        foreach ($unchecked_permissions as $permission_id) {
            UserPermission::updateOrCreate(
                ['user_id' => $user_id, 'permission_id' => $permission_id],
                ['status' => 'false']
            );
        }

        foreach ($checked_permissions as $permission_id) {
            UserPermission::updateOrCreate(
                ['user_id' => $user_id, 'permission_id' => $permission_id],
                ['status' => 'true']
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
        // Get the user ID from the authenticated user or wherever it's available
        $user_id = auth()->id(); // Assuming you're using Laravel's built-in authentication

        // Get the checked and unchecked permission arrays from the request
        $checked_permissions = $request->input('checked_permissions', []);
        $unchecked_permissions = $request->input('unchecked_permissions', []);

        // Set the status for unchecked permissions to 'false' and for checked permissions to 'true'
        foreach ($unchecked_permissions as $permission_id) {
            UserPermission::updateOrCreate(
                ['user_id' => $user_id, 'permission_id' => $permission_id],
                ['status' => 'false']
            );
        }

        foreach ($checked_permissions as $permission_id) {
            UserPermission::updateOrCreate(
                ['user_id' => $user_id, 'permission_id' => $permission_id],
                ['status' => 'true']
            );
        }




        // You can return a response if needed
        // toast('Settings Updated!', 'info');
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
            $currentMonthSales = Sale::where('store_id', $user->store->id)->where('status', 'Completed')->whereMonth('date', date('m'))
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
                // 
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

            $sale_payments = SalePayment::where('store_id', $user->store->id)->where('date', '>=', $date_range)
                ->select([
                    DB::raw("DATE_FORMAT(date, '%m-%Y') as month"),
                    DB::raw("SUM(amount) as amount")
                ])
                ->groupBy('month')->orderBy('month')
                ->get()->pluck('amount', 'month');

            $sale_return_payments = SaleReturnPayment::where('store_id', $user->store->id)->where('date', '>=', $date_range)
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
            $sales = Sale::where('store_id', $user->store->id)->where('status', 'Completed')
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

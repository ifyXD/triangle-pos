@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content')
    <div class="col-12 mt-5 permissionForm">
        <div class="card">
            <div class="card-body">


                <div class="form-group">
                    <label for="permissions"> Permissions <span class="text-danger">*</span>
                    </label>

                    <button type="button" class="btn btn-primary float-right mr-2" id="permissionBtnFunc">Continue</button>
                    <button type="button" class="btn btn-outlined-dark border-dark float-right mr-2"
                        id="backBtnpermission">Back</button>

                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" checked class="custom-control-input" id="select-all">
                        <label class="custom-control-label" for="select-all">Give All Permissions</label>
                    </div>
                </div>
                <form id="permissions-form">
                    <div class="row">
                        <!-- Dashboard Permissions -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Dashboard
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_total_stats" name="permissions[]" value="3">
                                                <label class="custom-control-label" for="show_total_stats">Total
                                                    Stats</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_notifications" name="permissions[]" value="7">
                                                <label class="custom-control-label"
                                                    for="show_notifications">Notifications</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_month_overview" name="permissions[]" value="4">
                                                <label class="custom-control-label" for="show_month_overview">Month
                                                    Overview</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_weekly_sales_purchases" name="permissions[]" value="5">
                                                <label class="custom-control-label" for="show_weekly_sales_purchases">Weekly
                                                    Sales &
                                                    Purchases</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_monthly_cashflow" name="permissions[]" value="6">
                                                <label class="custom-control-label" for="show_monthly_cashflow">Monthly
                                                    Cashflow</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Products
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_products" name="permissions[]" value="8">
                                                <label class="custom-control-label" for="access_products">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_products" name="permissions[]" value="10">
                                                <label class="custom-control-label" for="show_products">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_products" name="permissions[]" value="9">
                                                <label class="custom-control-label" for="create_products">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_products" name="permissions[]" value="11">
                                                <label class="custom-control-label" for="edit_products">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_products" name="permissions[]" value="12">
                                                <label class="custom-control-label" for="delete_products">Delete</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_product_categories" name="permissions[]" value="13">
                                                <label class="custom-control-label"
                                                    for="access_product_categories">Category</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Adjustments Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Adjustments
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_adjustments" name="permissions[]" value="15">
                                                <label class="custom-control-label"
                                                    for="access_adjustments">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_adjustments" name="permissions[]" value="16">
                                                <label class="custom-control-label"
                                                    for="create_adjustments">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_adjustments" name="permissions[]" value="17">
                                                <label class="custom-control-label" for="show_adjustments">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_adjustments" name="permissions[]" value="18">
                                                <label class="custom-control-label" for="edit_adjustments">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_adjustments" name="permissions[]" value="19">
                                                <label class="custom-control-label"
                                                    for="delete_adjustments">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Expenses Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Expenses
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_expenses" name="permissions[]" value="27">
                                                <label class="custom-control-label" for="access_expenses">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_expenses" name="permissions[]" value="28">
                                                <label class="custom-control-label" for="create_expenses">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_expenses" name="permissions[]" value="29">
                                                <label class="custom-control-label" for="edit_expenses">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_expenses" name="permissions[]" value="30">
                                                <label class="custom-control-label" for="delete_expenses">Delete</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_expense_categories" name="permissions[]" value="31">
                                                <label class="custom-control-label"
                                                    for="access_expense_categories">Category</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customers Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Customers
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_customers" name="permissions[]" value="32">
                                                <label class="custom-control-label" for="access_customers">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_customers" name="permissions[]" value="33">
                                                <label class="custom-control-label" for="create_customers">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_customers" name="permissions[]" value="34">
                                                <label class="custom-control-label" for="show_customers">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_customers" name="permissions[]" value="35">
                                                <label class="custom-control-label" for="edit_customers">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_customers" name="permissions[]" value="36">
                                                <label class="custom-control-label" for="delete_customers">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Suppliers Permission -->
                        {{-- <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Suppliers
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_suppliers" name="permissions[]" value="37">
                                                <label class="custom-control-label" for="access_suppliers">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_suppliers" name="permissions[]" value="38">
                                                <label class="custom-control-label" for="create_suppliers">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_suppliers" name="permissions[]" value="39">
                                                <label class="custom-control-label" for="show_suppliers">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_suppliers" name="permissions[]" value="40">
                                                <label class="custom-control-label" for="edit_suppliers">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_customers" name="permissions[]" value="41">
                                                <label class="custom-control-label" for="delete_customers">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Sales Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Sales
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_sales" name="permissions[]" value="42">
                                                <label class="custom-control-label" for="access_sales">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_sales" name="permissions[]" value="43">
                                                <label class="custom-control-label" for="create_sales">Create</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" checked class="custom-control-input"
                                            id="show_sales" name="permissions[]"
                                            value="show_suppliers">
                                        <label class="custom-control-label"
                                            for="show_sales">View</label>
                                    </div>
                                </div> --}}
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_sales" name="permissions[]" value="45">
                                                <label class="custom-control-label" for="edit_sales">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_sales" name="permissions[]" value="46">
                                                <label class="custom-control-label" for="delete_sales">Delete</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_pos_sales" name="permissions[]" value="47">
                                                <label class="custom-control-label" for="create_pos_sales">POS
                                                    System</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_sale_payments" name="permissions[]" value="48">
                                                <label class="custom-control-label"
                                                    for="access_sale_payments">Payments</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Returns Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Sale Returns
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_sale_returns" name="permissions[]" value="49">
                                                <label class="custom-control-label"
                                                    for="access_sale_returns">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_sale_returns" name="permissions[]" value="50">
                                                <label class="custom-control-label"
                                                    for="create_sale_returns">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_sale_returns" name="permissions[]" value="51">
                                                <label class="custom-control-label" for="show_sale_returns">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_sale_returns" name="permissions[]" value="52">
                                                <label class="custom-control-label" for="edit_sale_returns">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_sale_returns" name="permissions[]" value="53">
                                                <label class="custom-control-label"
                                                    for="delete_sale_returns">Delete</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_sale_return_payments" name="permissions[]" value="54">
                                                <label class="custom-control-label"
                                                    for="access_sale_return_payments">Payments</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purchases Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Purchases
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_purchases" name="permissions[]" value="55">
                                                <label class="custom-control-label" for="access_purchases">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_purchases" name="permissions[]" value="56">
                                                <label class="custom-control-label" for="create_purchases">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_purchases" name="permissions[]" value="57">
                                                <label class="custom-control-label" for="show_purchases">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_purchases" name="permissions[]" value="58">
                                                <label class="custom-control-label" for="edit_purchases">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_purchases" name="permissions[]" value="59">
                                                <label class="custom-control-label" for="delete_purchases">Delete</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_purchase_payments" name="permissions[]" value="60">
                                                <label class="custom-control-label"
                                                    for="access_purchase_payments">Payments</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purchases Returns Permission -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Purchase Returns
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_purchase_returns" name="permissions[]" value="61">
                                                <label class="custom-control-label"
                                                    for="access_purchase_returns">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_purchase_returns" name="permissions[]" value="62">
                                                <label class="custom-control-label"
                                                    for="create_purchase_returns">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="show_purchase_returns" name="permissions[]" value="63">
                                                <label class="custom-control-label"
                                                    for="show_purchase_returns">View</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_purchase_returns" name="permissions[]" value="64">
                                                <label class="custom-control-label"
                                                    for="edit_purchase_returns">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_purchase_returns" name="permissions[]" value="65">
                                                <label class="custom-control-label"
                                                    for="delete_purchase_returns">Delete</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_purchase_return_payments" name="permissions[]"
                                                    value="66">
                                                <label class="custom-control-label"
                                                    for="access_purchase_return_payments">Payments</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Currencies Permission -->
                        {{-- <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Currencies
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_currencies" name="permissions[]" value="68">
                                                <label class="custom-control-label" for="access_currencies">Access</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="create_currencies" name="permissions[]" value="69">
                                                <label class="custom-control-label" for="create_currencies">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="edit_currencies" name="permissions[]" value="70">
                                                <label class="custom-control-label" for="edit_currencies">Edit</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="delete_currencies" name="permissions[]" value="71">
                                                <label class="custom-control-label" for="delete_currencies">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Reports -->
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header">
                                    Reports
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" checked class="custom-control-input"
                                                    id="access_reports" name="permissions[]" value="67">
                                                <label class="custom-control-label" for="access_reports">Access</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush

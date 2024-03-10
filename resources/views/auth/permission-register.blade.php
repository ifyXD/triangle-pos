<div class="col-12 mt-5 permissionForm">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="permissions"> Permissions <span class="text-danger">*</span>
                </label>

                <button type="button"
                    class="btn btn-primary float-right permissionBtn">Continue</button>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="select-all">
                    <label class="custom-control-label" for="select-all">Give All Permissions</label>
                </div>
            </div>

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
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_total_stats" name="permissions[]"
                                            value="show_total_stats">
                                        <label class="custom-control-label" for="show_total_stats">Total
                                            Stats</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_notifications" name="permissions[]"
                                            value="show_notifications">
                                        <label class="custom-control-label"
                                            for="show_notifications">Notifications</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_month_overview" name="permissions[]"
                                            value="show_month_overview">
                                        <label class="custom-control-label"
                                            for="show_month_overview">Month Overview</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_weekly_sales_purchases" name="permissions[]"
                                            value="show_weekly_sales_purchases">
                                        <label class="custom-control-label"
                                            for="show_weekly_sales_purchases">Weekly Sales &
                                            Purchases</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_monthly_cashflow" name="permissions[]"
                                            value="show_monthly_cashflow">
                                        <label class="custom-control-label"
                                            for="show_monthly_cashflow">Monthly Cashflow</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management Permission -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header">
                            User Mangement
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_user_management" name="permissions[]"
                                            value="access_user_management">
                                        <label class="custom-control-label"
                                            for="access_user_management">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_own_profile" name="permissions[]"
                                            value="edit_own_profile">
                                        <label class="custom-control-label" for="edit_own_profile">Own
                                            Profile</label>
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_products" name="permissions[]"
                                            value="access_products">
                                        <label class="custom-control-label"
                                            for="access_products">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_products" name="permissions[]"
                                            value="show_products">
                                        <label class="custom-control-label"
                                            for="show_products">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_products" name="permissions[]"
                                            value="create_products">
                                        <label class="custom-control-label"
                                            for="create_products">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_products" name="permissions[]"
                                            value="edit_products">
                                        <label class="custom-control-label"
                                            for="edit_products">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_products" name="permissions[]"
                                            value="delete_products">
                                        <label class="custom-control-label"
                                            for="delete_products">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_product_categories" name="permissions[]"
                                            value="access_product_categories">
                                        <label class="custom-control-label"
                                            for="access_product_categories">Category</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="print_barcodes" name="permissions[]"
                                            value="print_barcodes">
                                        <label class="custom-control-label" for="print_barcodes">Print
                                            Barcodes</label>
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_adjustments" name="permissions[]"
                                            value="access_adjustments">
                                        <label class="custom-control-label"
                                            for="access_adjustments">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_adjustments" name="permissions[]"
                                            value="create_adjustments">
                                        <label class="custom-control-label"
                                            for="create_adjustments">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_adjustments" name="permissions[]"
                                            value="show_adjustments">
                                        <label class="custom-control-label"
                                            for="show_adjustments">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_adjustments" name="permissions[]"
                                            value="edit_adjustments">
                                        <label class="custom-control-label"
                                            for="edit_adjustments">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_adjustments" name="permissions[]"
                                            value="delete_adjustments">
                                        <label class="custom-control-label"
                                            for="delete_adjustments">Delete</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quotations Permission -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header">
                            Quotaions
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_quotations" name="permissions[]"
                                            value="access_quotations">
                                        <label class="custom-control-label"
                                            for="access_quotations">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_quotations" name="permissions[]"
                                            value="create_quotations">
                                        <label class="custom-control-label"
                                            for="create_quotations">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_quotations" name="permissions[]"
                                            value="show_quotations">
                                        <label class="custom-control-label"
                                            for="show_quotations">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_quotations" name="permissions[]"
                                            value="edit_quotations">
                                        <label class="custom-control-label"
                                            for="edit_quotations">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_quotations" name="permissions[]"
                                            value="delete_quotations">
                                        <label class="custom-control-label"
                                            for="delete_quotations">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="send_quotation_mails" name="permissions[]"
                                            value="send_quotation_mails">
                                        <label class="custom-control-label"
                                            for="send_quotation_mails">Send Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_quotation_sales" name="permissions[]"
                                            value="create_quotation_sales">
                                        <label class="custom-control-label"
                                            for="create_quotation_sales">Sale From Quotation</label>
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_expenses" name="permissions[]"
                                            value="access_expenses">
                                        <label class="custom-control-label"
                                            for="access_expenses">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_expenses" name="permissions[]"
                                            value="create_expenses">
                                        <label class="custom-control-label"
                                            for="create_expenses">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_expenses" name="permissions[]"
                                            value="edit_expenses">
                                        <label class="custom-control-label"
                                            for="edit_expenses">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_expenses" name="permissions[]"
                                            value="delete_expenses">
                                        <label class="custom-control-label"
                                            for="delete_expenses">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_expense_categories" name="permissions[]"
                                            value="access_expense_categories">
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_customers" name="permissions[]"
                                            value="access_customers">
                                        <label class="custom-control-label"
                                            for="access_customers">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_customers" name="permissions[]"
                                            value="create_customers">
                                        <label class="custom-control-label"
                                            for="create_customers">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_customers" name="permissions[]"
                                            value="show_customers">
                                        <label class="custom-control-label"
                                            for="show_customers">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_customers" name="permissions[]"
                                            value="edit_customers">
                                        <label class="custom-control-label"
                                            for="edit_customers">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_customers" name="permissions[]"
                                            value="delete_customers">
                                        <label class="custom-control-label"
                                            for="delete_customers">Delete</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suppliers Permission -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header">
                            Suppliers
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_suppliers" name="permissions[]"
                                            value="access_suppliers">
                                        <label class="custom-control-label"
                                            for="access_suppliers">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_suppliers" name="permissions[]"
                                            value="create_suppliers">
                                        <label class="custom-control-label"
                                            for="create_suppliers">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_suppliers" name="permissions[]"
                                            value="show_suppliers">
                                        <label class="custom-control-label"
                                            for="show_suppliers">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_suppliers" name="permissions[]"
                                            value="edit_suppliers">
                                        <label class="custom-control-label"
                                            for="edit_suppliers">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_customers" name="permissions[]"
                                            value="delete_customers">
                                        <label class="custom-control-label"
                                            for="delete_customers">Delete</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_sales" name="permissions[]"
                                            value="access_sales">
                                        <label class="custom-control-label"
                                            for="access_sales">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_sales" name="permissions[]"
                                            value="create_sales">
                                        <label class="custom-control-label"
                                            for="create_sales">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_sales" name="permissions[]"
                                            value="show_suppliers">
                                        <label class="custom-control-label"
                                            for="show_sales">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_sales" name="permissions[]" value="edit_sales">
                                        <label class="custom-control-label"
                                            for="edit_sales">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_sales" name="permissions[]"
                                            value="delete_sales">
                                        <label class="custom-control-label"
                                            for="delete_sales">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_pos_sales" name="permissions[]"
                                            value="create_pos_sales">
                                        <label class="custom-control-label" for="create_pos_sales">POS
                                            System</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_sale_payments" name="permissions[]"
                                            value="access_sale_payments">
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_sale_returns" name="permissions[]"
                                            value="access_sale_returns">
                                        <label class="custom-control-label"
                                            for="access_sale_returns">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_sale_returns" name="permissions[]"
                                            value="create_sale_returns">
                                        <label class="custom-control-label"
                                            for="create_sale_returns">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_sale_returns" name="permissions[]"
                                            value="show_sale_returns">
                                        <label class="custom-control-label"
                                            for="show_sale_returns">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_sale_returns" name="permissions[]"
                                            value="edit_sale_returns">
                                        <label class="custom-control-label"
                                            for="edit_sale_returns">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_sale_returns" name="permissions[]"
                                            value="delete_sale_returns">
                                        <label class="custom-control-label"
                                            for="delete_sale_returns">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_sale_return_payments" name="permissions[]"
                                            value="access_sale_return_payments">
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_purchases" name="permissions[]"
                                            value="access_purchases">
                                        <label class="custom-control-label"
                                            for="access_purchases">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_purchases" name="permissions[]"
                                            value="create_purchases">
                                        <label class="custom-control-label"
                                            for="create_purchases">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_purchases" name="permissions[]"
                                            value="show_purchases">
                                        <label class="custom-control-label"
                                            for="show_purchases">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_purchases" name="permissions[]"
                                            value="edit_purchases">
                                        <label class="custom-control-label"
                                            for="edit_purchases">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_purchases" name="permissions[]"
                                            value="delete_purchases">
                                        <label class="custom-control-label"
                                            for="delete_purchases">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_purchase_payments" name="permissions[]"
                                            value="access_purchase_payments">
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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_purchase_returns" name="permissions[]"
                                            value="access_purchase_returns">
                                        <label class="custom-control-label"
                                            for="access_purchase_returns">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_purchase_returns" name="permissions[]"
                                            value="create_purchase_returns">
                                        <label class="custom-control-label"
                                            for="create_purchase_returns">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="show_purchase_returns" name="permissions[]"
                                            value="show_purchase_returns">
                                        <label class="custom-control-label"
                                            for="show_purchase_returns">View</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_purchase_returns" name="permissions[]"
                                            value="edit_purchase_returns">
                                        <label class="custom-control-label"
                                            for="edit_purchase_returns">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_purchase_returns" name="permissions[]"
                                            value="delete_purchase_returns">
                                        <label class="custom-control-label"
                                            for="delete_purchase_returns">Delete</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_purchase_return_payments" name="permissions[]"
                                            value="access_purchase_return_payments">
                                        <label class="custom-control-label"
                                            for="access_purchase_return_payments">Payments</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Currencies Permission -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header">
                            Currencies
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_currencies" name="permissions[]"
                                            value="access_currencies">
                                        <label class="custom-control-label"
                                            for="access_currencies">Access</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="create_currencies" name="permissions[]"
                                            value="create_currencies">
                                        <label class="custom-control-label"
                                            for="create_currencies">Create</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="edit_currencies" name="permissions[]"
                                            value="edit_currencies">
                                        <label class="custom-control-label"
                                            for="edit_currencies">Edit</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="delete_currencies" name="permissions[]"
                                            value="delete_currencies">
                                        <label class="custom-control-label"
                                            for="delete_currencies">Delete</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_reports" name="permissions[]"
                                            value="access_reports">
                                        <label class="custom-control-label"
                                            for="access_reports">Access</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header">
                            Settings
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="access_settings" name="permissions[]"
                                            value="access_settings">
                                        <label class="custom-control-label"
                                            for="access_settings">Access</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="permission-wrapper">
    {{--    <h1 class="headline">Select <span>feature</span> that apply.</h1> --}}
    <form id="permissions-form">
        <div class="permission-container">
            <div class="buttons-container">
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="dashboardCheck"
                        value="3,4,5,6,7"
                        {{ $userpermissions[0]['status'] === 'true' ? 'checked' : '' }}>Dashboard</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="expensesCheck"
                        value="27,28,29,30,31" {{ $userpermissions[5]['status'] === 'true' ? 'checked' : '' }}>
                    Expenses</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="productCheck"
                        value="8,9,10,11,12,13"
                        {{ $userpermissions[10]['status'] === 'true' ? 'checked' : '' }}>Products</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="adjustmentCheck"
                        value="15,16,17,18,19"
                        {{ $userpermissions[16]['status'] === 'true' ? 'checked' : '' }}>Adjustments</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="customerCheck"
                        value="32,33,34,35,36"
                        {{ $userpermissions[21]['status'] === 'true' ? 'checked' : '' }}>Customers</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="saleCheck"
                        value="42,43,44,45,46,47,48"
                        {{ $userpermissions[26]['status'] === 'true' ? 'checked' : '' }}>Sales</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="salereturnCheck"
                        value="49,50,51,52,53,54" {{ $userpermissions[33]['status'] === 'true' ? 'checked' : '' }}>Sale
                    Returns</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="reportCheck"
                        value="67" {{ $userpermissions[39]['status'] === 'true' ? 'checked' : '' }}>Reports</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="priceCheck"
                        value="74" {{ $userpermissions[40]['status'] === 'true' ? 'checked' : '' }}>Prices</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="settingCheck"
                        value="41" {{ $userpermissions[41]['status'] === 'true' ? 'checked' : '' }}>Settings</label>
            </div>
            {{--            <button class="button-next" type="button" id="permissionBtnFunc">NEXT</button> --}}
            <div id="permissionBtnFunc" disabled class="form-group mb-0">
                <button type="button" id="submitNiBay" class="btn btn-primary"><i class="bi bi-check"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </form>

</div>
{{-- @dd($userpermissions[0]->status) --}}
{{-- {{ $userpermissions[55]->status === 'true' ? 'checked' : '' }} --}}

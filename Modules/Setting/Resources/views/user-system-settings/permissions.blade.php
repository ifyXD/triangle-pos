{{-- <div class="permission-wrapper"> 
    <form id="permissions-form">
        <div class="permission-container">
            <div class="buttons-container">
                <label class="checkbox-button">
                    <input type="checkbox" name="permissions[]" class="dashboardCheck" value="3,4,5,6,7"
                        {{ $userpermissions->where('permission_id', '3')->first()->status === 'true' ? 'checked' : '' }}>Dashboard
                </label>
           
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="productCheck"
                        value="8,9,10,11,12,13"
                        {{ $userpermissions->where('permission_id', '8')->first()->status === 'true' ? 'checked' : '' }}>Products</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="adjustmentCheck"
                        value="15,16,17,18,19"
                        {{ $userpermissions->where('permission_id', '15')->first()->status === 'true' ? 'checked' : '' }}>Adjustments</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="customerCheck"
                        value="32,33,34,35,36"
                        {{ $userpermissions->where('permission_id', '32')->first()->status === 'true' ? 'checked' : '' }}>Customers</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="saleCheck"
                        value="42,43,44,45,46,47,48"
                        {{ $userpermissions->where('permission_id', '42')->first()->status === 'true' ? 'checked' : '' }}>Sales</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="salereturnCheck"
                        value="49,50,51,52,53,54" {{ $userpermissions->where('permission_id', '49')->first()->status === 'true' ? 'checked' : '' }}>Total Purge Cost</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="reportCheck"
                        value="67" {{ $userpermissions->where('permission_id', '67')->first()->status === 'true' ? 'checked' : '' }}>Reports</label>
                <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="priceCheck"
                        value="74" {{ $userpermissions->where('permission_id', '74')->first()->status === 'true' ? 'checked' : '' }}>Prices</label>
                <label class="checkbox-button m-auto"><input type="checkbox" name="permissions[]" class="settingCheck"
                        value="41" {{ $userpermissions->where('permission_id', '41')->first()->status === 'true' ? 'checked' : '' }}>Settings</label>
            </div>
           
            <div id="permissionBtnFunc" disabled class="form-group mb-0">
                <button type="button" id="submitNiBay" class="btn btn-primary"><i class="bi bi-check"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </form>

</div> --}}

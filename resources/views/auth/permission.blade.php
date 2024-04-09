@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content')
    <div class="permission-wrapper">
        <h1 class="headline">Select <span>feature</span> that apply.</h1>
        <form id="permissions-form"> 
            <div class="permission-container">
                <div class="buttons-container">
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="dashboardCheck"
                            value="3,4,5,6,7" checked>Dashboard</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="expensesCheck"
                            value="27,28,29,30,31" checked>Expenses</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="productCheck"
                            value="8,9,10,11,12,13" checked>Products</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="adjustmentCheck"
                            value="15,16,17,18,19" checked>Adjustments</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="customerCheck"
                            value="32,33,34,35,36" checked>Customers</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="saleCheck"
                            value="42,43,44,45,46,47,48" checked>Sales</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="salereturnCheck"
                            value="49,50,51,52,53,54" checked>Sale Returns</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="reportCheck"
                            value="67" checked>Reports</label>
                    <label class="checkbox-button"><input type="checkbox" name="permissions[]" class="priceCheck"
                            value="74" checked>Prices</label>
                </div>
                <button class="button-next" type="button" id="permissionBtnFunc">NEXT</button>
            </div>
        </form>
        <a class="button-back" href="{{ url('registration-requirements-storename') }}" id="backBtnpermission">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <mask id="mask0_262_436" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                    height="24">
                    <rect width="24" height="24" fill="#D9D9D9" />
                </mask>
                <g mask="url(#mask0_262_436)">
                    <path d="M10 22L0 12L10 2L11.775 3.775L3.55 12L11.775 20.225L10 22Z" fill="#1C1B1F" />
                </g>
            </svg>
            <span>BACK</span>
        </a>
    </div>
@endsection
@push('scripts')
    @include('auth.registration-script')
@endpush

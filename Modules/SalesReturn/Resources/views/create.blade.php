@extends('layouts.app')

@section('title', 'Create Sale Return')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sale-returns.index') }}">Sale Returns</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12">
                <livewire:search-product />
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('utils.alerts')
                        <form id="sale-return-form" action="{{ route('sale-returns.store') }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" id="reference" required
                                            readonly value="SLRN">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                            <select class="form-control" name="customer_id" id="customer_id" required>
                                                @foreach (\Modules\People\Entities\Customer::when(
            auth()->user()->hasRole('Super Admin'),
            function ($query) {
                // If the user has the "Super Admin" role, retrieve all suppliers
            },
            function ($query) {
                // If not "Super Admin," filter suppliers by user_id
                $query->where('user_id', auth()->user()->id)->orWhere('user_id', 1);
            },
        )->orderBy('customer_name')->get() as $customer)
                                                    <option value="{{ $customer->id }}">
                                                        {{ Str::ucfirst($customer->customer_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="date">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required
                                                id="date" value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:product-cart :cartInstance="'sale_return'" />

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="returnOption">Select Return Option<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="returnOption" id="returnOption" required>
                                            <option value="return">Return to Inventory</option>
                                            <option value="loss">Damage Product/s</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="status" id="status" value="completed">
                                </div>
                                <div class="col-lg-4">
                                    <input type="hidden" name="payment_method" id="payment_method" value="Cash">

                                    <div class="form-group">
                                        <label for="paid_amount">Amount Received <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="paid_amount" type="text" class="form-control" name="paid_amount"
                                                required>
                                            <div class="input-group-append">
                                                {{-- <button id="getTotalAmount" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="from-group">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="payment_method" id="payment_method" required>
                                                <option value="Cash">Cash</option>
                                              
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="col-lg-4">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-primary" id="saleReturnSubmit">
                                    Create Sale Return <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
       


        $(document).ready(function() {

            $('#paid_amount').maskMoney({
                prefix: '{{ settings()->currency->symbol }}',
                thousands: '{{ settings()->currency->thousand_separator }}',
                decimal: '{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#getTotalAmount').click(function() {
                $('#paid_amount').maskMoney('mask', {{ Cart::instance('sale_return')->total() }});
            });

            $('#sale-return-form').submit(function() {
                var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                $('#paid_amount').val(paid_amount);
            });
            $('#saleReturnSubmit').click(function() {
                let customer_id = $('#customer_id').val();
                let amount = $('#paid_amount').val();
                let paid_amount = parseFloat(amount.replace('₱', '').trim());
                let total_amount = $('#total_amount').val();
                let payment_method = $('#payment_method').val();
                let note = $('#note').val();
                let status = $('#status').val();
                let date = $('#date').val();
                let reference = $('#reference').val();
                let returnOption = $('#returnOption').val();

                var cartDetails = [];

                $('tr[data-product-id]').each(function() {
                    // Extract data from the current <tr>
                    var productId = $(this).data('product-id');
                    var productName = $(this).find('td:eq(0)').text();
                    var pricePerProductUnit = $(this).find('.price-per-product-unit').val();
                    var pricePerUnit = $(this).find('select.price-per-unit').find(':selected')
                        .text();
                    var price_id = $(this).find('select.price-per-unit').find(':selected')
                        .data('price_id');
                    var stock_id = $(this).find('select.price-per-unit').find(':selected')
                        .data('stock_id');
                    var quantity = $(this).find('.quantity').val();
                    var subTotalVal = $(this).find('.sub-total').text();
                    var subTotal = parseFloat(subTotalVal.replace('₱', '').replace(',', ''));
                    // Create an object to represent the cart detail
                    var cartDetail = {
                        productId: productId,
                        productName: productName,
                        pricePerProductUnit: pricePerProductUnit,
                        pricePerUnit: pricePerUnit,
                        quantity: quantity,
                        price_id: price_id,
                        stock_id: stock_id,
                        subTotal: subTotal,
                    };

                    // Push the cart detail object into the array
                    cartDetails.push(cartDetail);
                });
                // console.log(cartDetails);

                $.post('{{ route('sale-returns.store') }}', {
                        cartDetails: cartDetails,
                        customer_id: customer_id,
                        paid_amount: paid_amount,
                        total_amount: total_amount,
                        payment_method: payment_method,
                        note: note,
                        status: status,
                        date: date,
                        reference: reference,
                        return_status: returnOption,
                    })
                    .done(function(response) {
                        // Success callback
                        // console.log(cartDetails);
                        window.location = "{{ route('sale-returns.index') }}";
                        // You can perform further actions here based on the server response
                    })
                    .fail(function(xhr, status, error) {
                        // Failure callback
                        console.error(xhr);
                        // You can handle errors or show an error message to the user
                    });

            });
        });
    </script>
@endpush

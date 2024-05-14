@extends('layouts.app')

@section('title', 'Edit Sale')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
        <li class="breadcrumb-item active">Edit</li>
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
                        <form id="sale-form" action="{{ route('sales.update', $sale) }}" method="POST">
                            @csrf
                            @method('patch')

                            <div class="form-row">
                                <div class="col-lg-4">
                                    {{-- <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="reference" name="reference" required
                                            value="{{ $sale->reference }}" readonly>
                                    </div> --}}
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
                                            <input type="date" class="form-control" name="date" id="date"
                                                required value="{{ $sale->date }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:product-cart :cartInstance="'sale'" :data="$sale" />

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option {{ $sale->status == 'Pending' ? 'selected' : '' }} value="Pending">
                                                Pending</option>
                                            {{-- <option {{ $sale->status == 'Shipped' ? 'selected' : '' }} value="Shipped">Shipped</option> --}}
                                            <option {{ $sale->status == 'Completed' ? 'selected' : '' }} value="Completed">
                                                Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="payment_method"
                                                name="payment_method" required value="{{ $sale->payment_method }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="paid_amount">Amount Received <span class="text-danger">*</span></label>
                                        <input id="paid_amount" type="text" class="form-control" name="paid_amount"
                                            required value="{{ $sale->paid_amount }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $sale->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="editSaveBtn" class="btn btn-primary">
                                    Update Sale <i class="bi bi-check"></i>
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
        function grandTotal() {
            var grandTotal = 0;

            // Iterate through each <td> element in the table body
            $(`#cart_product tbody .tdClass`).each(function() {
                // Get the text content of the current <td>
                var text = $(this).text();

                // Remove the currency sign (₱) and any leading/trailing whitespace
                var value = parseFloat(text.replace('₱', '').trim());

                // Add the value to the grand total
                if (!isNaN(value)) {
                    grandTotal += value;
                }
            });


            // Set the grand total in your desired element
            $('#grand_total').text('₱' + grandTotal.toFixed(2));
            $('#total_amount').val(grandTotal.toFixed(2));

        };

        $(document).ready(function() {
           
            $('#editSaveBtn').click(function() {
                let customer_id = $('#customer_id').val();
                let amount = $('#paid_amount').val();
                let paid_amount = parseFloat(amount.replace('₱', '').trim());
                let total_amount = $('#total_amount').val();
                let payment_method = $('#payment_method').val();
                let note = $('#note').val();
                let status = $('#status').val();
                let date = $('#date').val();
                let reference = $('#reference').val();

                var cartDetails = [];

                $('tr[data-product-id]').each(function() {
                    // Extract data from the current <tr>
                    var productId = $(this).data('product-id');
                    var productName = $(this).find('td:eq(0)').text();
                    var price_id = $(this).data('price_id');
                    var unit_id = $(this).data('unit_id');
                    var stock_id = $(this).data('stock_id');
                    var quantity = $(this).find('.quantity').val();
                    var subTotalVal = $(this).find('.sub-total').text();
                    var subTotal = parseFloat(subTotalVal.replace('₱', '').replace(',', ''));
                    // Create an object to represent the cart detail
                    var cartDetail = {
                        productId: productId,
                        price_id: price_id,
                        unit_id: unit_id,
                        stock_id: stock_id,
                        productName: productName,
                        quantity: quantity,
                        subTotal: subTotal
                    };

                    // Push the cart detail object into the array
                    cartDetails.push(cartDetail);
                });
                // console.log(cartDetails);

                $.ajax({
                    url: '{{ route('sales.update', $sale) }}',
                    type: 'PATCH',
                    data: {
                        cartDetails: cartDetails,
                        customer_id: customer_id,
                        paid_amount: paid_amount,
                        total_amount: total_amount,
                        payment_method: payment_method,
                        note: note,
                        status: status,
                        date: date,
                    },
                    success: function(response) {
                        // Success callback
                        // console.log(response);
                        window.location = "{{ route('sales.index') }}";
                        // You can perform further actions here based on the server response
                    },
                    error: function(xhr, status, error) {
                        // Failure callback
                        console.error(xhr);
                        // You can handle errors or show an error message to the user
                    }
                });
            });
        });
    </script>
@endpush

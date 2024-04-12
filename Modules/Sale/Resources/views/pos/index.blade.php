@extends('layouts.app')

@section('title', 'POS')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">POS</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('utils.alerts')
            </div>
            <div class="col-lg-7">
                <livewire:search-product/>
                <livewire:pos.product-list :categories="$product_categories"/>
            </div>
            <div class="col-lg-5">
                {{-- <livewire:pos.checkout :cart-instance="'sale'" :customers="$customers"/>             --}}
                @include('sale::pos.checkout')

            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            window.addEventListener('showCheckoutModal', event => {
                $('#checkoutModal').modal('show');

                $('#paid_amount').maskMoney({
                    prefix:'{{ settings()->currency->symbol }}',
                    thousands:'{{ settings()->currency->thousand_separator }}',
                    decimal:'{{ settings()->currency->decimal_separator }}',
                    allowZero: false,
                });

                $('#total_amount').maskMoney({
                    prefix:'{{ settings()->currency->symbol }}',
                    thousands:'{{ settings()->currency->thousand_separator }}',
                    decimal:'{{ settings()->currency->decimal_separator }}',
                    allowZero: true,
                });

                $('#paid_amount').maskMoney('mask');
                $('#total_amount').maskMoney('mask');

                $('#checkout-form').submit(function () {
                    var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                    $('#paid_amount').val(paid_amount);
                    var total_amount = $('#total_amount').maskMoney('unmasked')[0];
                    $('#total_amount').val(total_amount);
                });
            });
        });
    </script>

@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.proceed_click').click(function() {
            let id = $(this).data('id');

            $(`.close${id}`).click();
        });


        $('.changePrice').change(function() {
            let id = $(this).data('id');
            // Get the selected price value
            var selectedPriceString = $(`.selectpricehere${id}`).val(); // Get the value as string
            // Remove currency symbol and ".00" from the string, then parse to float
            var selectedPrice = parseFloat(selectedPriceString.replace('₱', '').replace(',', ''));

            var product_quantity = parseInt($(`input#product_quantity${id}`).val());
            var total = selectedPrice *
                product_quantity; // Multiply the selectedPrice and product_quantity

            console.log(total);

            // Update the content of the target element with the selected price
            $(`#selectedPrice${id}`).text(selectedPriceString);
            $(`#grand_total_number${id}`).val(total.toFixed(
                2)); // Use toFixed(2) to ensure two decimal places
        });




    });
</script>


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
                <livewire:search-product />
                <livewire:pos.product-list :categories="$product_categories" />
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
        $(document).ready(function() {
            window.addEventListener('showCheckoutModal', event => {
                $('#checkoutModal').modal('show');

                $('#paid_amount').maskMoney({
                    prefix: '{{ settings()->currency->symbol }}',
                    thousands: '{{ settings()->currency->thousand_separator }}',
                    decimal: '{{ settings()->currency->decimal_separator }}',
                    allowZero: false,
                });

                $('#total_amount').maskMoney({
                    prefix: '{{ settings()->currency->symbol }}',
                    thousands: '{{ settings()->currency->thousand_separator }}',
                    decimal: '{{ settings()->currency->decimal_separator }}',
                    allowZero: true,
                });

                $('#paid_amount').maskMoney('mask');
                $('#total_amount').maskMoney('mask');

                $('#checkout-form').submit(function() {
                    var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                    $('#paid_amount').val(paid_amount);
                    var total_amount = $('#total_amount').maskMoney('unmasked')[0];
                    $('#total_amount').val(total_amount);
                });
            });
        });
    </script>
    <script>
        function updateGrandTotal() {
            // Calculate the total of all subtotals
            let grandTotal = 0;
            $('.tablecart tbody tr').each(function() {

                let subTotal = parseFloat($(this).find('.sub-total').text());
                // console.log(subTotal);
                grandTotal += subTotal;
            });

            // Update the grand total in the table
            $('.table-total th:last-child').text('(=) ' + grandTotal.toFixed(2));
            $('#total_amount').val(grandTotal.toFixed(2));
        }


        function proceedProduct(id) {

            let product_name = $(`.parentcontent${id}`).find(`#product_name${id}`).val();
            let qty = $(`.parentcontent${id}`).find(`#product_quantity${id}`).val();
            // Assuming `.selectpricehere${id}` is a select element
            let selectedOption = $(`.parentcontent${id}`).find(`.selectpricehere${id} option:selected`);
            let priceText = selectedOption.text();
            let priceValue = selectedOption.val();

            if (priceValue != 0) {
                let tbody = $('.tablecart tbody');

                if (tbody.find('tr').length == 1 && tbody.find('.no-product-message').length > 0) {
                    // Remove the "Please search & select products!" message
                    tbody.empty();
                    $('#proceed_cart').prop('disabled', true);
                }

                // Check if a row for this product already exists in the table
                let existingRow = tbody.find(`tr[data-product-id="${id}"]`);

                if (existingRow.length > 0) {
                    // Update the existing row
                    existingRow.find('.price-per-product-unit').text(priceValue);
                    existingRow.find('.price-per-unit').text(priceText);
                    existingRow.find('.quantity').text(qty);
                    existingRow.find('.sub-total').text((parseFloat(priceValue) * parseInt(qty)).toFixed(2));

                } else {

                    // Append a new row for the product
                    tbody.append(`
                <tr data-product-id="${id}" class="text-center">
                    <td>${product_name}</td>
                    <td class="price-per-product-unit">${priceValue}</td>
                    <td class="price-per-unit">${priceText}</td>
                    <td class="quantity">${qty}</td>
                    <td class="sub-total">${(parseFloat(priceValue) * parseInt(qty)).toFixed(2)}</td>
                    <td class="align-middle text-center">
                        <a href="#" class="removeItem">
                            <i class="bi bi-x-circle font-2xl text-danger"></i>
                        </a>
                    </td>
                </tr>
            `);
                }

                $(`.close${id}`).click();
            } else {
                alert('Please select a unit price');
            }
            updateGrandTotal();

        }


        $(document).ready(function() {
            $('body').on('click', '.removeItem', function() {
                $(this).closest('tr').remove();
                // Update the grand total after removing the item
                updateGrandTotal();

                // Check if the table is empty after removing the item
                let tbody = $('.tablecart tbody');
                if (tbody.find('tr').length == 0) {
                    // Show the "Please search & select products!" message
                    tbody.append(`
                                <tr>
                                    <td colspan="5" class="text-center no-product-message">
                                        <span class="text-danger">Please search & select products!</span>
                                    </td>
                                </tr>
                             `);
                }

                if ($('.tablecart tbody').find('td').hasClass('no-product-message') || $(this).val() ===
                    '') {
                    // If tbody contains a td with the class no-product-message or the value of the selected element is empty, disable the button with id proceed_cart
                    $('#proceed_cart').prop('disabled', true);
                } else {
                    // If tbody does not contain a td with the class no-product-message and the value of the selected element is not empty, enable the button with id proceed_cart
                    $('#proceed_cart').prop('disabled', false);
                }
            });

            $('.changePrice').change(function() {
                let id = $(this).data('id');
                // Get the selected price value
                var selectedPriceString = $(`.selectpricehere${id}`).val(); // Get the value as string
                // Remove currency symbol and ".00" from the string, then parse to float
                var selectedPrice = parseFloat(selectedPriceString.replace('₱', '').replace(',', ''));

                var product_quantity = parseInt($(`input#product_quantity${id}`).val());
                var total = selectedPrice * product_quantity;

                // Update the content of the target element with the selected price
                $(`#selectedPrice${id}`).text(selectedPriceString);
                $(`#grand_total_number${id}`).val(total.toFixed(
                    2)); // Use toFixed(2) to ensure two decimal places
            });

            $('#customer_id').change(function() {




                // Check if tbody in table with id tablecart contains a td with the class no-product-message
                if ($('.tablecart tbody').find('td').hasClass('no-product-message') || $(this).val() ===
                    '') {
                    // If tbody contains a td with the class no-product-message or the value of the selected element is empty, disable the button with id proceed_cart
                    $('#proceed_cart').prop('disabled', true);
                } else {
                    // If tbody does not contain a td with the class no-product-message and the value of the selected element is not empty, enable the button with id proceed_cart
                    $('#proceed_cart').prop('disabled', false);
                    $('.customer_id_selected').val($(this).val());
                }
            });



            $('#submit_product_data_sale').click(function() {
                var cartDetails = [];
                var customer_id = $('#customer_id').val();
                var paid_amount = $('#paid_amount').val();
                var total_amount = $('#total_amount').val();
                var payment_method = $('#payment_method').val();
                var note = $('#note').val();

                // Iterate over each <tr> element
                $('tr[data-product-id]').each(function() {
                    // Extract data from the current <tr>
                    var productId = $(this).data('product-id');
                    var productName = $(this).find('td:eq(0)').text();
                    var pricePerProductUnit = $(this).find('.price-per-product-unit').text();
                    var pricePerUnit = $(this).find('.price-per-unit').text();
                    var quantity = $(this).find('.quantity').text();
                    var subTotal = $(this).find('.sub-total').text();

                    // Create an object to represent the cart detail
                    var cartDetail = {
                        productId: productId,
                        productName: productName,
                        pricePerProductUnit: pricePerProductUnit,
                        pricePerUnit: pricePerUnit,
                        quantity: quantity,
                        subTotal: subTotal
                    };

                    // Push the cart detail object into the array
                    cartDetails.push(cartDetail);
                });

                // Output the cart details array to console for testing
                // console.log(cartDetails);
                // Make an AJAX POST request to send the cart details to the server
                // Make an AJAX POST request to send the cart details to the server
                $.post('{{ route('app.pos.store') }}', {
                        cartDetails: cartDetails,
                        customer_id: customer_id,
                        paid_amount: paid_amount,
                        total_amount: total_amount,
                        payment_method: payment_method,
                        note: note,
                    })
                    .done(function(response) {
                        // Success callback
                        // console.log(cartDetails);
                        window.location = "{{ route('sales.index') }}";
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

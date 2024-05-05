<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="table-responsive position-relative">
            <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center"
                style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <table class="table table-bordered" id="cart_product">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle">Product</th>
                        <th class="align-middle text-center">Price / Unit</th>
                        <th class="align-middle text-center">Stock</th>
                        <th class="align-middle text-center">Quantity</th>
                        {{-- <th class="align-middle text-center">Discount</th>
                    <th class="align-middle text-center">Tax</th> --}}
                        <th class="align-middle text-center">Sub Total</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cart_items->isNotEmpty())
                        @foreach ($cart_items as $cart_item)
                            <tr id="parent_tr_{{ $cart_item->id }}" data-product-id="{{ $cart_item->id }}">
                                <td class="align-middle">
                                    {{ $cart_item->name }} <br>
                                </td>
                                <td class="align-middle text-center">
                                    <input style="min-width: 40px;max-width: 100%;" type="text" readonly
                                        id="priceValue_{{ $cart_item->id }}" value="{{ $cart_item->price }}"
                                        class="form-control price-per-product-unit" min="0" value="0">
                                    <select name="unit_select_{{ $cart_item->id }}"
                                        onchange="selectedUnit({{ $cart_item->id }},$(this).find(':selected').data('product_quantity'), $(this).val());"
                                        id="unit_select_{{ $cart_item->id }}" style="min-width: 40px;max-width: 100%;"
                                        class="form-control price-per-unit">
                                        <option value="" disabled selected>Select Unit</option>
                                        @foreach (\Illuminate\Support\Facades\DB::table('prices')->where('prices.product_id', $cart_item->id)->join('stocks', 'prices.stock_id', 'stocks.id')->join('units', 'prices.unit_id', 'units.id')->select('stocks.product_quantity as product_quantity', 'prices.stock_id as stock_id', 'prices.unit_id as unit_id', 'prices.id as price_id', 'prices.product_price as product_price', 'units.name as name', 'units.short_name as short_name')->get() as $unit)
                                            <option {{ $cart_item->price == $unit->product_price ? 'selected' : '' }}
                                                data-unit_id="{{ $unit->unit_id }}"
                                                data-price_id="{{ $unit->price_id }}"
                                                data-stock_id="{{ $unit->stock_id }}"
                                                data-product_quantity="{{ $unit->product_quantity }}"
                                                value="{{ $unit->product_price }}">
                                                {{ $unit->name . ' | ' . $unit->short_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="align-middle text-center text-center">
                                    <span class="badge badge-info" id="stock_{{ $cart_item->id }}"></span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="input-group d-flex justify-content-center">
                                        <input id="qtyval_{{ $cart_item->id }}"
                                            onchange="quantity({{ $cart_item->id }}, $(this).val());"
                                            style="min-width: 40px;max-width: 90px;" type="number"
                                            class="form-control quantity" value="{{ $cart_item->qty }}" min="1"
                                            max="">
                                    </div>
                                </td>
                                <td class="align-middle text-center tdClass sub-total" id="td_{{ $cart_item->id }}">
                                    {{ format_currency($cart_item->options->sub_total) }}
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" onclick="removeItem($(this));">
                                        <i class="bi bi-x-circle font-2xl text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                                <span class="text-danger">
                                    Please search & select products!
                                </span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" name="total_amount" id="total_amount">
    <div class="row justify-content-md-end">
        <div class="col-md-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Grand Total</th>

                        <th id="grand_total">
                            (=)
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @foreach ($cart_items as $item)
        {{ $item->selected_unit }}
    @endforeach


</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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

    }

    function removeItem(element) {
        element.closest('tr').remove();
        grandTotal();
    }

    function selectedUnit(id, stock, price) {
        let qty = $(`#qtyval_${id}`).val();

        let sub_total = qty * price;
        $(`#priceValue_${id}`).val(price);
        $(`#td_${id}`).text('₱' + sub_total + '.00');

        $(`#parent_tr_${id}`).find(`#stock_${id}`).text(stock);
        $(`#qtyval_${id}`).attr('max', stock);


        grandTotal();
    }

    function quantity(id, value) {
        let price = $(`#priceValue_${id}`).val();
        let sub_total = value * price;
        $(`#td_${id}`).text('₱' + sub_total + '.00');

        grandTotal();

    }

    $(document).ready(function() {


        // Event handler for clicking the "Dup" lin
        $('#submitCreateSale').click(function() {
            let customer_id = $('#customer_id').val();
            let amount = $('#paid_amount').val();
            let paid_amount = parseFloat(amount.replace('₱', '').trim());
            let total_amount = $('#total_amount').val();
            let payment_method = $('#payment_method').val();
            let note = $('#note').val();
            let status = $('#status').val();
            let date = $('#date').val();

            var cartDetails = [];

            $('tr[data-product-id]').each(function() {
                // Extract data from the current <tr>
                var productId = $(this).data('product-id');
                var productName = $(this).find('td:eq(0)').text();
                var price_id = $(this).find('select.price-per-unit').find(':selected')
                    .data('price_id');
                var unit_id = $(this).find('select.price-per-unit').find(':selected')
                    .data('unit_id');
                var stock_id = $(this).find('select.price-per-unit').find(':selected')
                    .data('stock_id');
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
            console.log(cartDetails);

            $.post('{{ route('sales.store') }}', {
                    cartDetails: cartDetails,
                    customer_id: customer_id,
                    paid_amount: paid_amount,
                    total_amount: total_amount,
                    payment_method: payment_method,
                    note: note,
                    status: status,
                    date: date,
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


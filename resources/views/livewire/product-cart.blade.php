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
                        <th class="align-middle text-center">Sub Total</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cart_items->isNotEmpty())
                        @foreach ($cart_items as $cart_item)
                            <tr id="parent_tr_{{ $cart_item->id }}" 
                                data-price_id="{{ $cart_item->options->price_id }}"
                                data-stock_id="{{ $cart_item->id }}"
                                data-unit_id="{{ $cart_item->options->unit_id }}"
                                data-product-id="{{ $cart_item->id }}"
                                data-product_id="{{ $cart_item->options->product_id }}"
                                data-product_price="{{ $cart_item->options->price_value }}">
                                <td class="align-middle">
                                    {{ $cart_item->name }} <br>
                                </td>
                                <td class="align-middle text-center">
                                    {{ $cart_item->options->price_value }} / {{ $cart_item->options->unit }}
                                </td>
                                <td class="align-middle text-center text-center">
                                    <span class="badge badge-info"
                                        id="stock_{{ $cart_item->id }}">{{ $cart_item->options->stock }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="input-group d-flex justify-content-center">
                                        <input 
                                        {{-- wire:model="qty"   --}}
                                        value="1"
                                        {{-- wire:change="updateQuantity({{ $cart_item->id }}, {{ $qty }})" --}}
                                        onchange="quantity({{$cart_item->id}},{{$cart_item->options->price_value}});"
                                        type="number" class="form-control quantity" 
                                        min="1" max="{{ $cart_item->options->stock }}">
                                 
                                    </div>
                                </td>
                                <td class="align-middle text-center tdClass sub-total" id="td_{{ $cart_item->id }}">
                                    {{ format_currency($cart_item->subtotal) }}
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
                                        <i class="bi bi-x-circle font-2xl text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
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
                        <th id="grand_total"></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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

        console.log(id);
        let qty = $(`#qtyval_${id}`).val();

        let sub_total = qty * price;
        $(`#priceValue_${id}`).val(price);
        $(`#td_${id}`).text('₱' + sub_total + '.00');

        $(`#parent_tr_${id}`).find(`#stock_${id}`).text(stock);
        $(`#qtyval_${id}`).attr('max', stock);


        grandTotal();
    }

    function quantity(id, value) {
        let price = $(`#parent_tr_${id}`).data('product_price');
        let sub_total = value * price;
        $(`#td_${id}`).text('₱' + sub_total + '.00');

        grandTotal();
        tableSubtotal();

    }

    function tableSubtotal() {
        $.each($(`#cart_product tbody tr`), function(key, val) {
            let id = $(val).data('product-id');
            let qty = $(val).find('.quantity').val();
            let price = $(val).data('product_price');
            let sub_total = qty * price;
            $(`#td_${id}`).text('₱' + sub_total + '.00');

            grandTotal();
        });
    }


    $(document).ready(function() {


        // Event handler for clicking the "Dup" lin
        $('#submitCreateSale').click(function() {
          

            if($('#grand_total').text() == ''){
                alert('Please adjust the quantity');
                return false;
            }
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
                var productId = $(this).data('product_id');
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
                grand_total
                // Push the cart detail object into the array
                cartDetails.push(cartDetail);
            });
            // console.log(cartDetails);

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

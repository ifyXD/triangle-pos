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
                            <tr>
                                <td class="align-middle">
                                    {{ $cart_item->name }} <br>
                                    {{-- <span class="badge badge-success">
                                        {{ $cart_item->options->code }}
                                    </span>
                                    @include('livewire.includes.product-cart-modal') --}}
                                </td>

                                <td class="align-middle text-center">
                                    <input style="min-width: 40px;max-width: 100%;" type="text" readonly
                                        id="priceValue_{{ $cart_item->id }}" class="form-control" min="0"
                                        value="0">
                                    <select name="unit_select_{{ $cart_item->id }}"
                                        onchange="selectedUnit({{ $cart_item->id }}, $(this).val());"
                                        id="unit_select_{{ $cart_item->id }}" style="min-width: 40px;max-width: 100%;"
                                        class="form-control">
                                        <option value="" disabled selected>Select Unit</option>
                                        @foreach ($cart_item->options['prices'] as $priceOption)
                                            <option value="{{ $priceOption['price'] }}">
                                                {{ $priceOption['product_unit'] }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="align-middle text-center text-center">
                                    <span class="badge badge-info">{{ $cart_item->options->stock }}</span>
                                </td>

                                <td class="align-middle text-center">
                                    {{-- @include('livewire.includes.product-cart-quantity') --}}
                                    <div class="input-group d-flex justify-content-center">
                                        <input id="qtyval_{{ $cart_item->id }}"
                                            onchange="quantity({{ $cart_item->id }}, $(this).val());"
                                            style="min-width: 40px;max-width: 90px;" type="number" class="form-control"
                                            value="{{ $cart_item->qty }}" min="1"
                                            max="{{ $cart_item->options['stock'] }}">
                                    </div>

                                </td>

                                <td class="align-middle text-center tdClass" id="td_{{ $cart_item->id }}">
                                    {{ format_currency($cart_item->options->sub_total) }}
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

    <input type="hidden" name="total_amount">


    <div class="form-row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control" name="status" id="status" required>
                    <option value="Pending">Pending</option>
                    {{-- <option value="Shipped">Shipped</option> --}}
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="from-group">
                <div class="form-group">
                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                    <select class="form-control" name="payment_method" id="payment_method" required>
                        <option value="Cash">Cash</option>
                        {{-- <option value="Credit Card">Credit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Other">Other</option> --}}
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="paid_amount">Amount Received <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input id="paid_amount" type="text" class="form-control" name="paid_amount" required>
                    <div class="input-group-append">
                        {{-- <button id="getTotalAmount" class="btn btn-primary" type="button">
                            <i class="bi bi-check-square"></i>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="note">Note (If Needed)</label>
        <textarea name="note" id="note" rows="5" class="form-control"></textarea>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            Create Sale <i class="bi bi-check"></i>
        </button>
    </div>

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
        
    }

    function selectedUnit(id, price) {
        let qty = $(`#qtyval_${id}`).val();
        let sub_total = qty * price;
        $(`#priceValue_${id}`).val(price);
        $(`#td_${id}`).text('₱' + sub_total + '.00');
        grandTotal();
    }

    function quantity(id, value) {
        let price = $(`#priceValue_${id}`).val();
        let sub_total = value * price;
        $(`#td_${id}`).text('₱' + sub_total + '.00');

        grandTotal();

    }
    // $(document).ready(function() {

    // });
</script>

<div>
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <livewire:pos.filter :categories="$categories" />
            <div class="row position-relative">
                <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center"
                    style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                @forelse($products as $product)
                    {{-- <div wire:click.prevent="selectProduct({{ $product }})" class="col-lg-4 col-md-6 col-xl-3" --}}
                    <div class="col-lg-4 col-md-6 col-xl-3" data-toggle="modal"
                        data-target="#viewModal{{ $product->id }}" style="cursor: pointer;">
                        <div class="card border-0 shadow h-100">
                            <div class="position-relative" style="height: 50px; width: 100%; overflow: hidden;">
                                {{--                                <div style="background-image: url('{{ $product->getFirstMediaUrl('images') }}'); background-size: cover; height: 100%; width: 100%;"></div> --}}
                                <div class="badge badge-info mb-3 position-absolute" style="left:10px;top: 10px;">Stock:
                                    {{ $product->product_quantity }}</div>
                            </div>

                            <div class="card-body">
                                <div class="mb-2">
                                    <h6 style="font-size: 18px;" class="card-title mb-0">{{ $product->product_name }}
                                    </h6>
                                    <span class="badge badge-success">{{ $product->product_code }}</span>
                                </div>
                                <p style="font-size: 16px; text-align: end;" class="card-text font-weight-bold">
                                    @if ($product->min_price == $product->max_price)
                                        {{ format_currency($product->min_price) }}
                                    @else
                                        {{ format_currency($product->min_price) }} -
                                        {{ format_currency($product->max_price) }}
                                    @endif
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="viewModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Price: <span
                                            id="selectedPrice">{{ format_currency($product_selected_price) }}</span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_quantity">Quantity <span
                                                        class="text-danger">*</span></label>
                                                <input id="product_quantity" type="number" class="form-control"
                                                    name="product_quantity" required value="1" min="1"
                                                    max="{{ $product->product_quantity }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_stock_alert">Unit <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="product_{{ $product->id }}"
                                                    id="product_{{ $product->id }}">
                                                    @php
                                                        $unitPricePairs = explode('|', $product->all_prices);
                                                    @endphp
                                                    <option value="0" selected disabled>Select Unit</option>
                                                    @foreach ($unitPricePairs as $unitPricePair)
                                                        @php
                                                            [$unit, $price] = explode(':', $unitPricePair);
                                                        @endphp
                                                        <option value="{{ $price }}">{{ $unit }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_stock_alert">Grand Total: </label>
                                                <input type="number" disabled readonly id="grand_total_number"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary proceed_click"
                                        wire:click.prevent="selectProduct({{ $product }})">Proceed</button>
                                </div>
                            </div>
                        </div>
                    </div>


                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            Products Not Found...
                        </div>
                    </div>
                @endforelse
            </div>






            <div @class(['mt-3' => $products->hasPages()])>
                {{ $products->links() }}
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.proceed_click').click(function() {
            $('.close').click();
        });
        $('select.form-control').change(function() {
            // Get the selected price value
            var selectedPriceString = $(this).val(); // Get the value as string
            // Remove currency symbol and ".00" from the string, then parse to float
            var selectedPrice = parseFloat(selectedPriceString.replace('₱', '').replace(',', ''));

            var product_quantity = parseInt($('input#product_quantity').val());
            var total = selectedPrice *
            product_quantity; // Multiply the selectedPrice and product_quantity

            console.log(total);

            // Update the content of the target element with the selected price
            $('#selectedPrice').text(selectedPriceString);
            $('#grand_total_number').val(total.toFixed(
                2)); // Use toFixed(2) to ensure two decimal places
        });




    });
</script>

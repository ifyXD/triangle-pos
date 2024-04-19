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
                    @if ($product->min_price)
                        <div class="col-lg-4 col-md-6 col-xl-3" data-toggle="modal"
                            data-target="#viewModal{{ $product->id }}" style="cursor: pointer;">
                            <div class="card border-0 shadow h-100">
                                <div class="position-relative" style="height: 50px; width: 100%; overflow: hidden;">
                                    {{--                                <div style="background-image: url('{{ $product->getFirstMediaUrl('images') }}'); background-size: cover; height: 100%; width: 100%;"></div> --}}
                                    <div class="badge badge-info mb-3 position-absolute" style="left:10px;top: 10px;">
                                        Stock:
                                        {{ $product->product_quantity }}</div>
                                </div>

                                <div class="card-body">
                                    <div class="mb-2">
                                        <h6 style="font-size: 18px;" class="card-title mb-0">
                                            {{ $product->product_name }}
                                        </h6>

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
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                Products Not Found...
                            </div>
                        </div>
                    @endif

                    <!-- Modal -->
                    <div class="modal fade" id="viewModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content parentcontent{{ $product->id }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Price: <span
                                            id="selectedPrice{{ $product->id }}">{{ format_currency($product_selected_price) }}</span>
                                    </h5>
                                    <button type="button" class="close{{ $product->id }}" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_quantity">Quantity <span
                                                        class="text-danger">*</span></label>
                                                <input id="product_quantity{{ $product->id }}" type="number"
                                                    class="form-control changePrice" data-id="{{ $product->id }}"
                                                    name="product_quantity" required value="1" min="1"
                                                    max="{{ $product->product_quantity }}">
                                                <input id="product_name{{ $product->id }}" type="hidden"
                                                    class="form-control changePrice"
                                                    value="{{ $product->product_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <label for="product_stock_alert">Unit <span class="text-danger">*</span></label>
                                                <select class="form-control" name="product_{{ $product->id }}" id="product_{{ $product->id }}">
=======
                                                <label for="product_stock_alert">Unit <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control changePrice selectpricehere{{ $product->id }}"
                                                    data-id="{{ $product->id }}" name="product_{{ $product->id }}"
                                                    id="product_{{ $product->id }}">
                                                    @php
                                                        $unitPricePairs = explode('|', $product->all_prices);
                                                    @endphp
>>>>>>> 336c3407c75b03824706f2759e434780a0be65d5
                                                    <option value="0" selected disabled>Select Unit</option>
                                                    @php
                                                        $unitPricePairs = $product->all_prices ? explode('|', $product->all_prices) : [];
                                                    @endphp
                                                    @foreach ($unitPricePairs as $unitPricePair)
                                                        @php
                                                            $pair = explode(':', $unitPricePair);
                                                            if (isset($pair[0], $pair[1])) {
                                                                [$unit, $price] = $pair;
                                                            } else {
                                                                // Handle the case where the pair cannot be properly split
                                                                continue; // Skip this iteration
                                                            }
                                                        @endphp
                                                        <option value="{{ $price }}">{{ $unit }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_stock_alert">Grand Total: </label>
                                                <input type="number" disabled readonly
                                                    id="grand_total_number{{ $product->id }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary proceed_click"
                                        onclick="proceedProduct({{ $product->id }})">Proceed</button>

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

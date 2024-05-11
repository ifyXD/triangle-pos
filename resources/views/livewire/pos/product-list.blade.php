
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
                    @if (!$product->min_price || $product->product_quantity === 0)
                        {{-- <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                Products Not Found...
                            </div>
                        </div> --}}
                    @else
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
                                                <label for="product_quantity">Quantity<span
                                                        class="text-danger">*</span></label>
                                                <input id="product_quantity{{ $product->id }}" type="number"
                                                    class="form-control changePrice" data-id="{{ $product->id }}"
                                                    name="product_quantity" required value="1" min="1"
                                                    >
                                                <input id="product_name{{ $product->id }}" type="hidden"
                                                    class="form-control changePrice"
                                                    value="{{ $product->product_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_stock_alert">Unit <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    onchange="selectedUnit({{ $product->id }}, $(this));"
                                                    class="form-control changePrice selectpricehere{{ $product->id }}"
                                                    data-id="{{ $product->id }}" name="product_{{ $product->id }}"
                                                    id="product_{{ $product->id }}">
                                                    <option value="0" selected disabled>Select Unit</option>

                                                    @foreach (\Illuminate\Support\Facades\DB::table('prices')->where('stocks.product_quantity', '>', 0)->where('prices.product_id', $product->id)->join('stocks', 'prices.stock_id', 'stocks.id')->join('units', 'prices.unit_id', 'units.id')->select('prices.stock_id as stock_id', 'prices.unit_id as unit_id', 'prices.id as price_id', 'prices.product_price as product_price', 'units.name as name', 'units.short_name as short_name', 'stocks.product_quantity as product_quantity')->get() as $unit)
                                                        <option 
                                                            data-product_quantity="{{ $unit->product_quantity }}"
                                                            data-unit_id="{{ $unit->unit_id }}"
                                                            data-price_id="{{ $unit->price_id }}"
                                                            data-stock_id="{{ $unit->stock_id }}"
                                                            value="{{ $unit->product_price }}">
                                                            {{ $unit->name . ' | ' . $unit->short_name }}
                                                        </option>
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
                                        <div class="col-md-12">
                                            <label>Stock/s per unit</label> <br>
                                            @foreach (\Illuminate\Support\Facades\DB::table('prices')->where('stocks.product_quantity', '>', 0)->where('prices.product_id', $product->id)->join('stocks', 'prices.stock_id', 'stocks.id')->join('units', 'prices.unit_id', 'units.id')->select('prices.stock_id as stock_id', 'prices.unit_id as unit_id', 'prices.id as price_id', 'prices.product_price as product_price', 'units.name as name', 'units.short_name as short_name', 'stocks.product_quantity as product_quantity')->get() as $unit)
                                                <span>{{ $unit->name . ' | ' . $unit->short_name }}</span><span> : {{$unit->product_quantity}}</span> <br>
                                            @endforeach
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

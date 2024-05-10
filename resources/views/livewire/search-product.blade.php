<div class="position-relative">
    <div class="card mb-0 border-0 shadow-sm">
        <div class="card-body">
            <div class="form-group mb-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bi bi-search text-primary"></i>
                        </div>
                    </div>
                    <input wire:keydown.escape="resetQuery" wire:model.live.debounce.500ms="query" type="text"
                        class="form-control" placeholder="Type product name....">
                </div>
            </div>
        </div>
    </div>

    <div wire:loading class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
        <div class="card-body shadow">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($query))
        <div wire:click="resetQuery" class="position-fixed w-100 h-100"
            style="left: 0; top: 0; right: 0; bottom: 0;z-index: 1;"></div>
        @if ($search_results->isNotEmpty())
            @foreach ($search_results as $result)
                <div class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
                    <div class="card-body shadow">
                        {{-- <a href="#" wire:click="resetQuery"  wire:click.prevent="selectProduct({{$result->id}})">
                        {{$result->product_name}}
                    </a> --}}

                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <h4>{{ $result->product_name }} </h4>
                                    <label for="total_amount">Select Unit<span class="text-danger">*</span></label>
                                    <select name="" wire:model="unitId" wire:change="updateUnitId"
                                        class="form-control" id="">
                                        <option value="" selected>Select Unit</option>
                                        @foreach (\Illuminate\Support\Facades\DB::table('prices')->where('stocks.product_quantity', '>', 0)->where('prices.product_id', $result->id)->join('stocks', 'prices.stock_id', 'stocks.id')->join('units', 'prices.unit_id', 'units.id')->select('prices.stock_id as stock_id', 'prices.unit_id as unit_id', 'prices.id as price_id', 'prices.product_price as product_price', 'units.name as name', 'units.short_name as short_name', 'stocks.product_quantity as product_quantity')->get() as $unit)
                                            <option data-product_quantity="{{ $unit->product_quantity }}"
                                                data-unit_id="{{ $unit->unit_id }}"
                                                data-price_id="{{ $unit->price_id }}"
                                                data-stock_id="{{ $unit->stock_id }}" value="{{ $unit->stock_id }}">
                                                {{ $unit->name . ' | ' . $unit->short_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button {{ $unitId != 0 ? '' : 'disabled' }} class="btn btn-primary float-end mt-1"
                                        wire:click="resetQuery" wire:click.prevent="selectProduct({{ $unitId }})">
                                        Proceed
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            @endforeach

            @if ($search_results->count() >= $how_many)
                <li class="list-group-item list-group-item-action text-center">
                    <a wire:click.prevent="loadMore" class="btn btn-primary btn-sm" href="#">
                        Load More <i class="bi bi-arrow-down-circle"></i>
                    </a>
                </li>
            @endif
        @else
            <div class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
                <div class="card-body shadow">
                    <div class="alert alert-warning mb-0">
                        No Product Found....
                    </div>
                </div>
            </div>
        @endif
    @endif

</div>

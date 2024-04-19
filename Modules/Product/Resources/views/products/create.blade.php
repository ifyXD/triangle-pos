@php use Modules\Setting\Entities\Unit; @endphp
@extends('layouts.app')

@section('title', 'Create Product')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Create Product <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Product Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="product_name" required
                                               value="{{ old('product_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach (\Modules\Product\Entities\Category::orderBy('category_name')->get() as $category)
                                                    @if (auth()->user()->hasRole('Super Admin'))
                                                        <option
                                                            value="{{ $category->id }}">{{ $category->category_name }}
                                                        </option>
                                                    @else
                                                        @if ($category->user_id == auth()->user()->id || $category->user_id == 1)
                                                            <option
                                                                value="{{ $category->id }}">{{ $category->category_name }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </select>
                                            <div class="input-group-append d-flex">
                                                <button data-toggle="modal" data-target="#categoryCreateModal"
                                                        class="btn btn-outline-primary" type="button">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                            </div>


                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_quantity">Quantity <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="product_quantity" required
                                               value="{{ old('product_quantity') }}" min="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_stock_alert">Alert Quantity <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="product_stock_alert" required
                                               value="{{ old('product_stock_alert', 0) }}" min="0" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="product_unit">Unit
                                        <i class="bi bi-question-circle-fill text-info"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Select the appropriate unit required for the product's use.">
                                        </i>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group-append d-flex form-group">
                                        <a href="{{ url('units/create') }}" class="btn btn-outline-primary">Add</a>
                                    </div>
                                    <div class="input-group form-group flex-column">
                                        {{--<select class="form-control" multiple name="product_unit[]" id="product_unit">
                                            --}}{{--<option value="" selected disabled>Select Unit</option>--}}{{--
                                            @foreach (Unit::orderBy('name')->get() as $unit)
                                                @if (auth()->user()->hasRole('Super Admin'))
                                                    <option
                                                        value="{{ $unit->short_name }}">
                                                        {{ $unit->name .' | '. $unit->short_name }}
                                                    </option>
                                                @else
                                                    @if ($unit->user_id == auth()->user()->id || $unit->user_id == 1)
                                                        <option
                                                            value="{{ $unit->short_name }}">
                                                            {{ $unit->name .' | '. $unit->short_name }}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>--}}

                                        {{--<select class="form-control" multiple name="product_unit[]" id="product_unit">
                                            @foreach (Unit::where('user_id', auth()->user()->id)->orWhere('user_id', 1)->orderBy('name')->get() as $unit)
                                                <option value="{{ $unit->short_name }}">{{ $unit->name .' | '. $unit->short_name }}</option>
                                            @endforeach
                                        </select>--}}



{{--                                        @foreach (Unit::where('user_id', auth()->user()->id)->orWhere('user_id', 1)->orderBy('name')->get() as $unit)--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input class="form-check-input" type="checkbox" name="product_unit[]" id="unit_{{ $unit->id }}" value="{{ $unit->short_name }}">--}}
{{--                                                <label class="form-check-label" for="unit_{{ $unit->id }}">--}}
{{--                                                    {{ $unit->name .' | '. $unit->short_name }}--}}
{{--                                                    {{ $unit->name }}--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}



                                        <div class="row">
                                            <div class="col-md-6">
                                                @php
                                                    $units = Unit::where('user_id', auth()->user()->id)->orWhere('user_id', 1)->orderBy('name')->get();
                                                    $halfCount = ceil($units->count() / 2);
                                                    $firstHalf = $units->slice(0, $halfCount);
                                                @endphp
                                                @foreach ($firstHalf as $unit)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="product_unit[]" id="unit_{{ $unit->id }}" value="{{ $unit->short_name }}">
                                                        <label class="form-check-label" for="unit_{{ $unit->id }}">
                                                            {{ $unit->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-md-6">
                                                @php
                                                    $secondHalf = $units->slice($halfCount);
                                                @endphp
                                                @foreach ($secondHalf as $unit)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="product_unit[]" id="unit_{{ $unit->id }}" value="{{ $unit->short_name }}">
                                                        <label class="form-check-label" for="unit_{{ $unit->id }}">
                                                            {{ $unit->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_note">Note</label>
                                        <textarea name="product_note" id="product_note" rows="4 "
                                                  class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="image">Product Images <i class="bi bi-question-circle-fill text-info"
                                                                     data-toggle="tooltip" data-placement="top"
                                                                     title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                <div class="dropzone d-flex flex-wrap align-items-center justify-content-center"
                                     id="document-dropzone">
                                    <div class="dz-message" data-dz-message>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Create Category Modal -->
    @include('product::includes.category-modal')
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection

@push('page_scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('dropzone.upload') }}',
            maxFilesize: 1,
            acceptedFiles: '.jpg, .jpeg, .png',
            maxFiles: 3,
            addRemoveLinks: true,
            dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                uploadedDocumentMap[file.name] = response.name;
            },
            removedfile: function (file) {
                file.previewElement.remove();
                var name = '';
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name;
                } else {
                    name = uploadedDocumentMap[file.name];
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('dropzone.delete') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'file_name': `${name}`
                    },
                });
                $('form').find('input[name="document[]"][value="' + name + '"]').remove();
            },
            init: function () {
                @if (isset($product) && $product->getMedia('images'))
                var files = {!! json_encode($product->getMedia('images')) !!};
                for (var i in files) {
                    var file = files[i];
                    this.options.addedfile.call(this, file);
                    this.options.thumbnail.call(this, file, file.original_url);
                    file.previewElement.classList.add('dz-complete');
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                }
                @endif
            }
        }
    </script>

    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#product_cost').maskMoney({
                prefix: '{{ settings()->currency->symbol }}',
                thousands: '{{ settings()->currency->thousand_separator }}',
                decimal: '{{ settings()->currency->decimal_separator }}',
            });
            $('#product_price').maskMoney({
                prefix: '{{ settings()->currency->symbol }}',
                thousands: '{{ settings()->currency->thousand_separator }}',
                decimal: '{{ settings()->currency->decimal_separator }}',
            });

            $('#product-form').submit(function () {
                var product_cost = $('#product_cost').maskMoney('unmasked')[0];
                var product_price = $('#product_price').maskMoney('unmasked')[0];
                $('#product_cost').val(product_cost);
                $('#product_price').val(product_price);
            });
        });
    </script>
@endpush

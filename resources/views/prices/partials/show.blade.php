@extends('layouts.app')

@section('title', 'Price Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('prices.index') }}">Prices</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="row mb-3">
            <div class="col-md-12">
                {{-- {!! \Milon\Barcode\Facades\DNS1DFacade::getBarCodeSVG($product->product_code, $product->product_barcode_symbology, 2, 110) !!} --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0 mx-auto">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $product->product_name }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Cost</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($prices as $item)
                                        <tr>
                                            <td>{{ $item->name. ' | '. $item->short_name }}</td>
                                            <td>{{ format_currency($item->product_cost) }}</td>
                                            <td>{{ format_currency($item->product_price) }}</td>
                                            <td>
                                                @if (auth()->user()->hasAccessToPermission('access_prices'))
                                                    <a href="{{ url('prices/edit/' . $item->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endif

                                                @if (auth()->user()->hasAccessToPermission('delete_products'))
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();
                                                            if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                document.getElementById('destroy{{ $item->id }}').submit()
                                                            }
                                                            ">
                                                        <i class="bi bi-trash"></i>
                                                        <form id="destroy{{ $item->id }}" class="d-none"
                                                            action="{{ route('prices.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">

                        
                        @forelse($product->getMedia('images') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Product Image" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Product Image" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

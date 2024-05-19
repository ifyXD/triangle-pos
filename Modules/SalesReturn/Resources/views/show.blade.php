@extends('layouts.app')

@section('title', 'Sales Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sale-returns.index') }}">Sale Returns</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        {{-- <div>
                            Reference: <strong>{{ $sale_return->reference }}</strong>
                        </div> --}}
                        {{-- <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('sale-returns.pdf', $sale_return->id) }}">
                            <i class="bi bi-printer"></i> Print
                        </a>
                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('sale-returns.pdf', $sale_return->id) }}">
                            <i class="bi bi-save"></i> Save
                        </a> --}}
                    </div>
                    <div class="card-body">
                        {{-- <div class="row mb-4">
                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Company Info:</h5>
                                <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                                <div>Email: {{ settings()->company_email }}</div>
                                <div>Phone: {{ settings()->company_phone }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Customer Info:</h5>
                                <div><strong>{{ $customer->customer_name }}</strong></div>
                                <div>{{ $customer->address }}</div>
                                <div>Email: {{ $customer->customer_email }}</div>
                                <div>Phone: {{ $customer->customer_phone }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                                <div>Invoice: <strong>INV/{{ $sale_return->reference }}</strong></div>
                                <div>Date: {{ \Carbon\Carbon::parse($sale_return->date)->format('d M, Y') }}</div>
                                <div>
                                    Status: <strong>{{ $sale_return->status }}</strong>
                                </div>
                                <div>
                                    Payment Status: <strong>{{ $sale_return->payment_status }}</strong>
                                </div>
                            </div>

                        </div> --}}

                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle">Net Unit Price</th>
                                    <th class="align-middle">Quantity</th>
                                    {{-- <th class="align-middle">Discount</th>
                                    <th class="align-middle">Tax</th> --}}
                                    <th class="align-middle">Sub Total</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                         $total_val = 0;
                                    @endphp
                                @foreach($sale_return->saleReturnDetails as $item)
                                @php
                                    $total_val += $item->price->product_price * $item->quantity;
                                @endphp
                                    <tr>
                                        <td class="align-middle">
                                            {{ $item->product->product_name }}<br>
                                            {{-- <span class="badge badge-success">
                                                {{ $item->product_code }}
                                            </span> --}}
                                        </td>

                                        <td class="align-middle">{{ format_currency($item->price->product_price) }} / {{$item->unit->name}}</td>

                                        <td class="align-middle">
                                            {{ $item->quantity }}
                                        </td>

                                        {{-- <td class="align-middle">
                                            {{ format_currency($item->product_discount_amount) }}
                                        </td>

                                        <td class="align-middle">
                                            {{ format_currency($item->product_tax_amount) }}
                                        </td> --}}

                                        <td class="align-middle">
                                            {{ format_currency($item->price->product_price*$item->quantity) }}
                                        </td>

                                        <td class="align-middle">
                                            {{ $item->return_status }}
                                        </td>
                                        <td class="align-middle">
                                            <a class="btn btn-primary" @disabled(true) onclick="return confirm('Are you sure you want to return this to stocks?')" href="{{ url('stock-update-return-stock', $item->id) }}">Return to stocks</a>
                                            <a class="btn btn-danger" onclick="return confirm('Are you sure you want to saved this as product loss?')" href="{{ route('product-loss.store', $item->id) }}">Product Loss</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-5 ml-md-auto">
                                <table class="table">
                                    <tbody> 
                                    <tr>
                                        <td class="left"><strong>Grand Total</strong></td>
                                        <td class="right"><strong>{{ format_currency($total_val) }}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


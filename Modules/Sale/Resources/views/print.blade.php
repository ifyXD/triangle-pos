<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Details</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div style="text-align: center;margin-bottom: 25px;">
                    {{-- <img width="180" src="{{ public_path('images/logo-dark.png') }}" alt="Logo"> --}}
                    <h4>{{ strtoupper(auth()->user()->setting->company_name) }}
                    </h4>
                </div>
                <div class="card">
                    <div class="card-body">


                        <div class="table-responsive-sm" style="margin-top: 30px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">Item</th>
                                        <th class="align-middle">Net Unit Price</th>
                                        <th class="align-middle">Quantity</th>
                                        <th class="align-middle">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->saleDetails as $item)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $item->product_name }} <br>
                                                <span class="badge badge-success">
                                                    {{ $item->product_code }}
                                                </span>
                                            </td>

                                            <td class="align-middle">{{ $item->price }}.00 / {{$item->unit_price}}</td>

                                            <td class="align-middle">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $item->sub_total * 100 }}.00
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <table class="table">
                                    <tbody>
                                        
                                        <tr>
                                            <td class="left"><strong>Grand Total</strong></td>
                                            <td class="right">
                                                <strong>{{ $sale->total_amount }}.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 25px;">
                            <div class="col-xs-12">
                                <p style="font-style: italic;text-align: center">{{ settings()->company_name }} &copy;
                                    {{ date('Y') }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

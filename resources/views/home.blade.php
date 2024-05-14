@extends('layouts.app')
@section('title', 'Home')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Home</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        @can('show_total_stats')
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-bar-chart font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($revenue) }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">Revenue</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                                <i class="bi bi-arrow-return-left font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-warning">{{ format_currency($sale_returns) }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">Sales Return</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                                <i class="bi bi-trophy font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-info">{{ format_currency($profit) }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">Profit</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                                <i class="bi bi-arrow-return-right font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-success">{{ $total_products }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">Total Products</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                                <i class="bi bi-arrow-return-right font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-success">{{ count($low_quantity_products) }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">Low Stock Products</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                                <i class="bi bi-arrow-return-right font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-success">{{ count($out_of_stocks) }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">Out of Stock Products</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endcan

        @can('show_weekly_sales_purchases|show_month_overview')
            <div class="row mb-4">
                @can('show_weekly_sales_purchases')
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header">
                                Sales & Purchases of Last 7 Days
                            </div>
                            <div class="card-body">
                                <canvas id="salesPurchasesChart"></canvas>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('show_month_overview')
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header">
                                Overview of {{ now()->format('F, Y') }}
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <div class="chart-container" style="position: relative; height:auto; width:280px">
                                    <canvas id="currentMonthChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        @endcan

        @can('show_monthly_cashflow')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            Monthly Cash Flow ({{ date('F Y') }})
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{url('home')}}" method="get">
                                        @csrf
                                        <label for="">Filter By Category</label>
                                        <select name="category_id" id="" class="form-control w-50">
                                            <option value="" selected>Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
        integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@push('page_scripts')
    @vite('resources/js/chart-config.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myChart').getContext('2d');

            var products = {!! json_encode($products) !!};
            var totals = {!! json_encode($totals) !!};
            var month = '{{ date('F Y') }}';

            // Combine products and totals into an array of objects
            var data = products.map((product, index) => ({
                product: product,
                total: totals[index]
            }));

            // Sort the data by total in descending order
            data.sort((a, b) => b.total - a.total);

            // Extract sorted products and totals
            products = data.map(item => item.product);
            totals = data.map(item => item.total);

            var datasets = [{
                label: month,
                data: totals,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }];

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: products,
                    datasets: datasets
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endpush

<style>
    .hidden {
        display: none !important;
    }
</style>



<button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
    data-class="c-sidebar-show">
    <i class="bi bi-list" style="font-size: 2rem;"></i>
</button>

<button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
    data-class="c-sidebar-lg-show" responsive="true">
    <i class="bi bi-list" style="font-size: 2rem;"></i>
</button>

<ul class="c-header-nav ml-auto">

</ul>
<ul class="c-header-nav ml-auto mr-4">
    @if (!auth()->user()->hasRole('Super Admin'))
        @can('create_pos_sales')
            <li class="c-header-nav-item mr-3">
                <a class="btn btn-primary btn-pill {{ request()->routeIs('app.pos.index') ? 'hidden' : '' }}"
                    href="{{ route('app.pos.index') }}">
                    <i class="bi bi-cart mr-1"></i> POS System
                </a>
            </li>
        @endcan
    @endif

    @if (!auth()->user()->hasRole('Super Admin'))
        @can('show_notifications')
            <li class="c-header-nav-item dropdown d-md-down-none mr-2">
                <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bi bi-bell" style="font-size: 20px;"></i>
                    <span class="badge badge-pill badge-danger">
                        @php
                            $low_quantity_products = auth()->user()->hasRole('Super Admin')
                                ? \App\Models\Stock::select(
                                    'stocks.id',
                                    'stocks.product_quantity',
                                    'stocks.product_stock_alert',
                                )
                                    ->join('products', 'stocks.product_id', 'products.id')
                                    ->whereColumn('stocks.product_quantity', '<=', 'stocks.product_stock_alert')
                                    ->select('products.product_name as product_name', 'products.id as id')
                                    ->get()
                                : \App\Models\Stock::select(
                                    'stocks.id',
                                    'stocks.product_quantity',
                                    'stocks.product_stock_alert',
                                )
                                    ->where('stocks.store_id', auth()->user()->store->id)
                                    ->join('products', 'stocks.product_id', 'products.id')
                                    ->select('products.product_name as product_name', 'products.id as id')
                                    ->whereColumn('stocks.product_quantity', '<=', 'stocks.product_stock_alert')
                                    ->get();
                            echo $low_quantity_products->count();
                        @endphp
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
                    <div class="dropdown-header bg-light">
                        <strong>{{ $low_quantity_products->count() }} Notifications</strong>
                    </div>
                    @forelse($low_quantity_products as $product)
                        <a class="dropdown-item" href="{{ url('stocks/show/' . $product->id) }}">
                            <i class="bi bi-hash mr-1 text-primary"></i> Product: "{{ $product->product_name }}" is
                            low in
                            stock!
                        </a>
                    @empty
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-app-indicator mr-2 text-danger"></i> No notifications available.
                        </a>
                    @endforelse
                </div>
            </li>
        @endcan
    @endif

    <li class="c-header-nav-item dropdown">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false">
            <div class="c-avatar mr-2" title="{{ auth()->user()->first_name }}">
                @if (auth()->user()->hasRole('Super Admin'))
                    <img class="c-avatar rounded-circle" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}"
                        alt="Profile Image">
                @else
                    <img class="c-avatar rounded-circle"
                        src="{{ auth()->user()->store->image == 'avatar.png'
                            ? auth()->user()->getFirstMediaUrl('avatars')
                            : asset('storage/' . auth()->user()->store->image) }}"
                        alt="Profile Image">
                @endif


            </div>

        </a>
        <div class="dropdown-menu dropdown-menu-right pt-0">
            <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="mfe-2  bi bi-person" style="font-size: 1.2rem;"></i> Profile
            </a>
            <a class="dropdown-item" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mfe-2  bi bi-box-arrow-left" style="font-size: 1.2rem;"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
</ul>

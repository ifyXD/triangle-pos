@if (auth()->user()->hasAccessToPermission('access_products'))
    <a href="{{ url('stocks/create/'. $data->id) }}" class="btn btn-info btn-sm">
        <i class="bi bi-plus"></i>
    </a>
    
@endif

@if (auth()->user()->hasAccessToPermission('access_products'))
    <a href="{{ route('stocks.show', $data->id) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-eye"></i>
    </a>
@endif
 
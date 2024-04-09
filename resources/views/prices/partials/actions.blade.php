@if (auth()->user()->hasAccessToPermission('access_prices'))
    <a href="{{ url('prices/create/'. $data->id) }}" class="btn btn-info btn-sm">
        <i class="bi bi-plus"></i>
    </a>
    
@endif

@if (auth()->user()->hasAccessToPermission('access_prices'))
    <a href="{{ route('prices.show', $data->id) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-eye"></i>
    </a>
@endif
 
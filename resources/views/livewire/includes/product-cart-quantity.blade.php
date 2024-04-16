<div class="input-group d-flex justify-content-center">
    <input  wire:model="quantity.{{ $cart_item->id }}" style="min-width: 40px;max-width: 90px;" type="number" class="form-control" value="{{ $cart_item->qty }}" min="1" max="{{$cart_item->options['stock']}}">
</div>

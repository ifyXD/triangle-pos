<div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <span>{{ session('message') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i>
                            </a>
                        </div>
                        <select id="customer_id" class="form-control">
                            <option value="" selected>Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table tablecart">
                        <thead>
                            <tr class="text-center">
                                <th class="align-middle">Product</th>
                                <th class="align-middle">Unit</th>
                                <th class="align-middle">Price</th>
                                <th class="align-middle">Quantity</th>
                                <th class="align-middle">Sub Total</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="text-center no-product-message">
                                    <span class="text-danger">
                                        Please search & select products!
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-total table-striped">
                            <tr class="text-primary">
                                <th>Grand Total</th>
                                <th>(=) 0.00</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


            <div class="form-group d-flex justify-content-center flex-wrap mb-0">
                <button type="button" class="btn btn-pill btn-danger mr-3"><i class="bi bi-x"></i> Reset</button>
                <button type="button" data-toggle="modal" data-target="#cartSelect" id="proceed_cart" disabled
                    class="btn btn-pill btn-primary"><i class="bi bi-check"></i> Proceed</button>
            </div>
        </div>
    </div>

    {{-- Checkout Modal --}}
    @include('livewire.pos.includes.checkout-modal')

</div>

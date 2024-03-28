@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content')
    <div class="container-fluid">
        <form action="{{route('updaterequirements')}}" method="POST">
            @csrf
            <h1>Let's give your store a name
                <input  class="storename"type="text" name="storename" required style="border: none; border-bottom: 1px solid black; background-color: transparent;">
                <input type="hidden" name="requestdata" value="storename">
                <button type="submit" class="btn btn-outlined-primary border-dark ml-3 rounded-pill">Proceed</button>
            </h1>
        </form>


    </div>
@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush

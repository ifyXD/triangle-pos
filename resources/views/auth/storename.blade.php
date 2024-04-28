@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content') 
    <style>
        input[type=text]:focus, textarea:focus {
            width: 660px;
            border: none;
            border-bottom: 2px solid rgba(81, 203, 238, 1);
        }
    </style>
    <div class="store">
        <div class="container-fluid">
            <form class="store-container" action="{{route('updaterequirements')}}" method="post"
                  style="transform: translateY(clamp(10px, 20vh, 30vh));">
                @csrf
                <h1 class="headline">Let's give your store a <span>name</span></h1>
                <div class="input-container">
                    <label for="storename" class="visually-hidden">Store Name:</label>
                    <input class="storename" type="text" id="storename" name="storename" required>
                    <input type="hidden" name="requestdata" value="storename">
                    <button class="button-next" type="submit">NEXT</button>
                </div>
            </form>


        </div>
    </div>

@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush

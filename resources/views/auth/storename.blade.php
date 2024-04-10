@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content')

    {{--    <div class="container-fluid">--}}
    {{--        <form action="{{route('updaterequirements')}}" method="POST">--}}
    {{--            @csrf--}}
    {{--            <h1>Let's give your store a name--}}
    {{--                <input  class="storename"type="text" name="storename" required style="border: none; border-bottom: 1px solid black; background-color: transparent;">--}}
    {{--                <input type="hidden" name="requestdata" value="storename">--}}
    {{--                <button type="submit" class="btn btn-outlined-primary border-dark ml-3 rounded-pill">Proceed</button>--}}
    {{--            </h1>--}}
    {{--        </form>--}}
    {{--    </div>--}}

    <div class="store">
        <div class="container-fluid">
                <form class="store-container" action="{{route('updaterequirements')}}" method="post">
                    @csrf
                    <h1 class="headline">Let's give your store a <span>name</span> </h1>
                    <div class="input-container">
                        <label for="storename" class="visually-hidden">Store Name:</label>
                        <input class="storename" type="text" id="storename" name="storename" required>
                        <input type="hidden" name="requestdata" value="storename">
                        <button class="button-next" type="submit">NEXT</button>
                    </div>




                    {{--<a class="button-back" href="{{ url("/") }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <mask id="mask0_262_436" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
                                  height="24">
                                <rect width="24" height="24" fill="#D9D9D9"/>
                            </mask>
                            <g mask="url(#mask0_262_436)">
                                <path d="M10 22L0 12L10 2L11.775 3.775L3.55 12L11.775 20.225L10 22Z" fill="#1C1B1F"/>
                            </g>
                        </svg>
                        <span>BACK</span>
                    </a>--}}
                </form>




        </div>
    </div>

@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush

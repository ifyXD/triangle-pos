@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content')

    <div class="pre-made-palette-container">
        <h1 class="headline">Choose a Pre-made <span>Palette</span></h1>
        <div class="palette-container-container">
            <div class="palette-container">
                @php
                    $colors = [
                        ['--color-1', '--color-0', '--color-2'],
                        ['--color-3', '--color-0', '--color-4'],
                        ['--color-5', '--color-0', '--color-6'],
                        ['--color-7', '--color-0', '--color-8'],
                        ['--color-9', '--color-0', '--color-10'],
                        ['--color-11', '--color-0', '--color-12'],
                        ['--color-13', '--color-0', '--color-14'],
                        ['--color-15', '--color-0', '--color-16'],
                        ['--color-17', '--color-0', '--color-18'],
                        ['--color-19', '--color-0', '--color-20'],
                        ['--color-21', '--color-0', '--color-22'],
                        ['--color-23', '--color-0', '--color-24'],
                        ['--color-25', '--color-0', '--color-26'],
                        ['--color-27', '--color-0', '--color-28'],
                        ['--color-29', '--color-0', '--color-30'],
                        ['--color-31', '--color-0', '--color-32'],
                        ['--color-33', '--color-0', '--color-34'],
                        ['--color-35', '--color-0', '--color-36'],
                        ['--color-37', '--color-0', '--color-38'],
                        ['--color-39', '--color-0', '--color-40'],
                    ];
                    $val = [
                        ['#575787', '#F0F5F4', '#33333d'],
                        ['#8CE4CC', '#F0F5F4', '#8D314B'],
                        ['#0D74DC', '#F0F5F4', '#e800a8'],
                        ['#F3A1FC', '#F0F5F4', '#1E3243'],
                        ['#F19553', '#F0F5F4', '#402B41'],
                        ['#196D49', '#F0F5F4', '#8B7D88'],
                        ['#68DFF9', '#F0F5F4', '#97311E'],
                        ['#7923E4', '#F0F5F4', '#B55D4F'],
                        ['#E87979', '#F0F5F4', '#3F4E4F'],
                        ['#E9BB00', '#F0F5F4', '#1C3B68'],
                        ['#7FD462', '#F0F5F4', '#0C4258'],
                        ['#7FBDFE', '#F0F5F4', '#3B3C58'],
                        ['#7D52C8', '#F0F5F4', '#0C4258'],
                        ['#9D2C52', '#F0F5F4', '#1F3352'],
                        ['#FDD60F', '#F0F5F4', '#181229'],
                        ['#34D6AC', '#F0F5F4', '#385D51'],
                        ['#17B8D4', '#F0F5F4', '#AC7D74'],
                        ['#B489F9', '#F0F5F4', '#46403A'],
                        ['#E26F31', '#F0F5F4', '#0000e6'],
                        ['#C3A67B', '#F0F5F4', '#3C485E'],
                    ];
                @endphp
                @foreach ($colors as $key => $palette)
                    <div class="parent">
                        <div class="palette" tabindex="0"> <!-- Add tabindex="0" to make it focusable -->
                            <div class="left-color" data-color="{{ $val[$key][0] }}"
                                 style="background: var({{ $palette[0] }});">
                            </div>
                            <div class="middle-color" data-color="{{ $val[$key][1] }}"
                                 style="background: var({{ $palette[1] }});">
                            </div>
                            <div class="right-color" data-color="{{ $val[$key][2] }}"
                                 style="background: var({{ $palette[2] }});">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="legend-container">
                <div class="single-legend">
                    <div class="square-legend first-div-bgcolor"></div>
                    <p class="legend-text first-color">#000000</p>
                </div>

                <div class="single-legend">
                    <div class="square-legend second-div-bgcolor"></div>
                    <p class="legend-text second-color">#000000</p>
                </div>

                <div class="single-legend">
                    <div class="square-legend third-div-bgcolor"></div>
                    <p class="legend-text third-color">#000000</p>
                </div>


            </div>
            <button class="button-next" id="paletteBtnSubmit" type="submit">FINISH</button>

        </div>
        <a class="button-back" href="{{ url('registration-requirements-permission') }}">
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
        </a>
    </div>

    {{--<div class="d-flex justify-content-end">
        <button id="paletteBtnSubmit" disabled class="progress-button btn btn-success rounded-pill fs-5">
            Proceed
        </button>
    </div>--}}


    {{--<button type="button" id="btn_backpallete" class="btn btn-outline-dark border-dark">Back</button>--}}


    <div class="progressbar">
        <span class="progress"></span>
    </div>
    <div class="counter"></div>
    <script>
        document.getElementById("paletteBtnSubmit").addEventListener("click", function () {
            document.querySelector(".progress").style.background = "#34D6AC"; // add color sa progress hays
        });

    </script>

    {{--     <div style="position: absolute; right:-20%;">--}}

    {{--         <div class="card" style="width: 15rem;">--}}
    {{--             <div class="card-body">--}}
    {{--                 <h5 class="card-title text-end">Legend</h5>--}}
    {{--                 <hr>--}}

    {{--                 <div style="position: relative; margin-bottom: -15px">--}}
    {{--                     <div class="first-div-bgcolor" style="width: 25px; height: 25px; background-color: #000000">--}}
    {{--                     </div>--}}
    {{--                     <span class="first-color text-dark h5"--}}
    {{--                         style="position: absolute; top:0; right: 0;">#000000</span><br>--}}
    {{--                 </div>--}}
    {{--                 <div style="position: relative; margin-bottom: -15px">--}}
    {{--                     <div class="second-div-bgcolor"--}}
    {{--                         style="width: 25px; height: 25px; background-color: #000000">--}}
    {{--                     </div>--}}
    {{--                     <span class="second-color text-dark h5"--}}
    {{--                         style="position: absolute; top:0; right: 0;">#000000</span><br>--}}
    {{--                 </div>--}}
    {{--                 <div style="position: relative; margin-bottom: -15px">--}}
    {{--                     <div class="third-div-bgcolor" style="width: 25px; height: 25px; background-color: #000000">--}}
    {{--                     </div>--}}
    {{--                     <span class="third-color text-dark h5"--}}
    {{--                         style="position: absolute; top:0; right: 0;">#000000</span><br>--}}
    {{--                 </div>--}}
    {{--             </div>--}}
    {{--         </div>--}}
    {{--     </div>--}}

@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush

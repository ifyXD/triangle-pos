@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content') 
    <section>
        <div class="">
            <button type="button" id="btn_backpallete" class="btn btn-outline-dark border-dark">Back</button>
            <h1 class="display-1"><strong>Choose</strong> a Pre-made Palette</h1>
            <p></p>
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
                        ['#38383B', '#F0F5F4', '#A1A1A1'],
                        ['#79DFC1', '#F0F5F4', '#B04A68'],
                        ['#0A58CA', '#F0F5F4', '#ff00bb'],
                        ['#E36FF7', '#F0F5F4', '#233D4D'],
                        ['#E17726', '#F0F5F4', '#51344D'],
                        ['#0F5132', '#F0F5F4', '#A38F99'],
                        ['#3DD5F3', '#F0F5F4', '#B73B23'],
                        ['#6610F2', '#F0F5F4', '#C97064'],
                        ['#E56B6B', '#F0F5F4', '#4C5B5C'],
                        ['#DFA400', '#F0F5F4', '#203878'],
                        ['#6CB14F', '#F0F5F4', '#114B5F'],
                        ['#6EA8FE', '#F0F5F4', '#474973'],
                        ['#6F42C1', '#F0F5F4', '#114B5F'],
                        ['#8B1E3F', '#F0F5F4', '#23395B'],
                        ['#FAB803', '#F0F5F4', '#1A1423'],
                        ['#20C997', '#F0F5F4', '#426A5A'],
                        ['#0AA2C0', '#F0F5F4', '#DBB4AC'],
                        ['#A370F7', '#F0F5F4', '#504746'],
                        ['#DE6528', '#F0F5F4', '#1100FF'],
                        ['#B99253', '#F0F5F4', '#495867'],
                    ];
                @endphp


                @foreach ($colors as $key => $palette)
                    <div class="parent">
                        <div class="palette">
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


                <div style="position: absolute; right:-20%;">

                    <div class="card" style="width: 15rem;">
                        <div class="card-body">
                            <h5 class="card-title text-end">Legend</h5>
                            <hr>

                            <div style="position: relative; margin-bottom: -15px">
                                <div class="first-div-bgcolor" style="width: 25px; height: 25px; background-color: #000000">
                                </div>
                                <span class="first-color text-dark h5"
                                    style="position: absolute; top:0; right: 0;">#000000</span><br>
                            </div>
                            <div style="position: relative; margin-bottom: -15px">
                                <div class="second-div-bgcolor"
                                    style="width: 25px; height: 25px; background-color: #000000">
                                </div>
                                <span class="second-color text-dark h5"
                                    style="position: absolute; top:0; right: 0;">#000000</span><br>
                            </div>
                            <div style="position: relative; margin-bottom: -15px">
                                <div class="third-div-bgcolor" style="width: 25px; height: 25px; background-color: #000000">
                                </div>
                                <span class="third-color text-dark h5"
                                    style="position: absolute; top:0; right: 0;">#000000</span><br>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="d-flex justify-content-end">
                <button id="paletteBtnSubmit" disabled class="btn btn-success rounded-pill w-100 fs-5">Proceed</button>
            </div>


            <div class="counter"></div>
            <div class="progressbar">
                <span class="progress"></span>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush

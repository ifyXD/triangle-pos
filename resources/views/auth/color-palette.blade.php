@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content')
    <section>
        <div class="mt-5">
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

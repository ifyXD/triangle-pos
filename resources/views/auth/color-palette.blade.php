@extends('auth.requirements-registration')
@section('title', 'Color Palette')
@section('content')
    @php
        $userId = auth()->id(); // Get the authenticated user's ID
        $userEmail = auth()->user()->email; // Get the authenticated user's email (or any unique identifier)

                // Construct session keys with a prefix using the user's unique identifier
        $selectedElementKey = 'selectedElement_' . $userId;
        $storenameKey = 'storename_' . $userId; 

        // If the session variable is not set, set it to a default value
        if (!session()->has($selectedElementKey)) {
            session([$selectedElementKey => 'first']); // or any default value you prefer
        }
        if (!session()->has($storenameKey)) {
            session([$storenameKey => '']); // or any default value you prefer
        }
    @endphp

    <h1>{{ session($selectedElementKey) }}</h1> 
    <div class="container-fluid {{ session($selectedElementKey) != 'first' ? 'd-none' : '' }} firstPage">
        <h1>Let's give your store a name
            <input value="{{ session($storenameKey) }}" class="storename"type="text" placeholder="store name" required
                style="border: none; border-bottom: 1px solid black; background-color: transparent;">

            <button type="button" class="btn btn-outlined-primary border-dark ml-3 rounded-pill"
                id="nextBtn">Proceed</button>
        </h1>


    </div>

    @include('auth.permission-register')

    <section>
        <div class="{{ session($selectedElementKey) != 'third' ? 'd-none' : '' }}">

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
                        ['#0A58CA', '#F0F5F4', '#E0CCAF'],
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
                        ['#DE6528', '#F0F5F4', '#C9E2EF'],
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
    <script>
        var first = '';
        var second = '';
        var third = '';
        $(document).ready(function() {

            $("#nextBtn").click(function() {
                var inputValue = $("input.storename").val();
                if (inputValue.trim() === '') {
                    alert("Please enter a store name.");
                    return false;
                } else {
                    $.post('/update-session/registration-requirements', {
                        selectedElement: 'second',
                        storename: inputValue,
                        id: {{ auth()->user()->id }},
                    }, function(data) {
                        location.reload();
                    }).fail(function() {
                        alert('An error occurred while updating the session.');
                    });
                }
            });

            $(".backBtn").click(function() {
                $.post('/update-session/registration-requirements', {
                    selectedElement: 'first',
                    storename: '{{ session('storename_' . auth()->user()->id) }}',
                    id: {{ auth()->user()->id }},
                }, function(data) {
                    location.reload();
                }).fail(function() {
                    alert('An error occurred while updating the session.');
                });
            });

            $('.permissionBtn').click(function() {


                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('.permissionForm').addClass('d-none');
                $('.registrationForm').removeClass('d-none');

                $.post('/update-session/registration-requirements', {
                    selectedElement: 'third',
                    storename: '{{ session('storename') }}',
                    id: {{ auth()->user()->id }},
                });
                location.reload();

            });


            $('.parent').click(function() {
                $('.parent').removeClass('border-parent');
                $(this).addClass('border-parent');

                first = $(this).find('.left-color').data('color');
                second = $(this).find('.middle-color').data('color');
                third = $(this).find('.right-color').data('color');

                $('.first-color').text(first);
                $('.second-color').text(second);
                $('.third-color').text(third);

                $('.first-div-bgcolor').css('background-color', first);
                $('.second-div-bgcolor').css('background-color', second);
                $('.third-div-bgcolor').css('background-color', third);

                //remove the disabled attr of paletteBtnSubmit id element
                $('#paletteBtnSubmit').removeAttr('disabled');

            });


            var progress = $('.progressbar .progress');

            // Define counterInit function
            function counterInit(fValue, lValue) {
                var counter_value = parseInt($('.counter').text()) || 0;
                counter_value++;

                if (counter_value <= 100) {
                    $('.counter').text(counter_value + '%');
                    $('.progress').css({
                        'width': counter_value + '%'
                    });

                    setTimeout(function() {
                        counterInit(fValue, lValue);
                    }, 120);

                    if (counter_value === 100) {
                        $.ajax({
                            method: 'POST',
                            url: '/update/registration-requirements',
                            data: {
                                'first': first,
                                'second': second,
                                'third': third,
                            },
                            success: function(data) {
                                window.location.href = "{{ route('home') }}";
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                            }
                        });
                    }
                }
            }


            // Bind click event to start counting
            $('#paletteBtnSubmit').click(function() {
                counterInit(0, 100); // Start counting when the button is clicked
            });
            $('#select-all').click(function() {
                $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });


        });
    </script>
@endpush

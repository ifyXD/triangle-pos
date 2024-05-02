@extends('layouts.app')

@section('title', 'Edit Settings')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">System Settings</li>
    </ol>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/merged-styles.css') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('system-settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-12">
                                    <label for="image">Profile Image <span class="text-danger">*</span></label>
                                    <div class="form-group text-center">
                                        @if (auth()->user()->setting && auth()->user()->setting->image)
                                            <img style="width: 100px; height: 100px; object-fit: cover;"
                                                class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2"
                                                src="{{ auth()->user()->setting->image == 'avatar.png'
                                                    ? asset('images/logo.png')
                                                    : asset('storage/' . auth()->user()->setting->image) }}"
                                                alt="Profile Image">
                                        @else
                                            <img style="width: 100px; height: 100px;"
                                                class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2"
                                                src="{{ asset('images/logo.png') }}" alt="Default Image">
                                        @endif
                                        <input id="image" type="file" name="image" data-max-file-size="500KB">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="user_id"
                                            value="{{ auth()->user()->id }}" required>
                                        <label for="company_name">Store Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_name"
                                            value="{{ $settings->company_name ?? null }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_email">Store Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_email"
                                            value="{{ $settings->company_email ?? null }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_phone">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_phone"
                                            value="{{ $settings->company_phone ?? null }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                    {{-- <div class="form-group">
                                            <label for="default_currency_id">Default Currency <span
                                                    class="text-danger">*</span></label>
                                            <select name="default_currency_id" id="default_currency_id" class="form-control"
                                                required>
                                                @foreach (\Modules\Currency\Entities\Currency::all() as $currency)
                                                    <option
                                                        {{ optional($settings)->default_currency_id == $currency->id ? 'selected' : '' }}
                                                        value="{{ $currency->id ?? null }}">{{ $currency->currency_name }}
                                                    </option>
                                                @endforeach
                                            </select>  <div class="col-lg-4">
                                    
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="default_currency_position">Default Currency Position <span
                                                    class="text-danger">*</span></label>
                                            <select name="default_currency_position" id="default_currency_position"
                                                class="form-control" required>
                                                <option
                                                    {{ optional($settings)->default_currency_position == 'prefix' ? 'selected' : '' }}
                                                    value="prefix">Prefix
                                                </option>
                                                <option
                                                    {{ optional($settings)->default_currency_position == 'suffix' ? 'selected' : '' }}
                                                    value="suffix">Suffix
                                                </option>
                                            </select>
                                        </div>
                                    </div> --}}

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="notification_email">Notification Email <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="notification_email"
                                            value="{{ optional($settings)->notification_email }}">
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="company_address">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_address"
                                            value="{{ optional($settings)->company_address }}">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mb-0">
                                <button type="submit" id="submitNi" class="btn btn-primary"><i class="bi bi-check"></i>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Permissions</h5>
                    </div>
                    <div class="card-body">
                        @include('setting::user-system-settings.permissions')

                    </div>
                </div>


                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Theme Customizer</h5>
                    </div>
                    <div class="card-body">
                        @include('setting::user-system-settings.color-palette')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
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
                    storename: '{{ session('storename_' . auth()->user()->id) }}',
                    id: {{ auth()->user()->id }},
                }, function(data) {
                    location.reload();
                }).fail(function() {
                    alert('An error occurred while updating the session.');
                });
            });

            $('#btn_backpallete').click(function() {
                window.location.href = "{{ route('registration.requirements-permission') }}";
            });
            $('#backBtnpermission').click(function() {
                window.location.href = "{{ route('registration.requirements-storename') }}";
            });
            $('#submitNiBay').click(function() {
                var checkedValues = [];
                var uncheckedValues = [];

                // Loop through each checkbox
                $('input[name="permissions[]"]').each(function() {
                    var values = $(this).val().split(',').filter(Boolean); // Remove empty values
                    if ($(this).is(':checked')) {
                        checkedValues.push(...values); // Concatenate checked values
                    } else {
                        uncheckedValues.push(...values); // Concatenate unchecked values
                    }
                });

                // Remove duplicate values
                checkedValues = [...new Set(checkedValues)];
                uncheckedValues = [...new Set(uncheckedValues)];

                console.log(uncheckedValues);

                // Send the checked and unchecked values to your Laravel controller using AJAX
                $.ajax({
                    url: '/update-session/registration-requirements/withpermission_update',
                    type: 'POST',
                    data: {
                        checked_permissions: checkedValues,
                        unchecked_permissions: uncheckedValues
                    },
                    success: function(response) {
                        // Handle success response
                        // console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr, status, error);
                    }
                });
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
                $('#asdSubmit').removeAttr('disabled');

            });


            var progress = $('.progressbar .progress');

            // Define counterInit function
            function counterInit(fValue, lValue) {
                $('.progressbar').removeClass('d-none');
                var counter_value = parseInt($('.counter').text()) || 0;
                counter_value++;

                if (counter_value <= 100) {
                    $('.counter').text(counter_value + '%');
                    $('.progress').css({
                        'width': counter_value + '%'
                    });

                    setTimeout(function() {
                        counterInit(fValue, lValue);
                    }, 10);

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
                                location.reload();
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

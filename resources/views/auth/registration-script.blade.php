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

        $('#permissionBtnFunc').click(function() {

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

            // Send the checkedValues array to your Laravel controller using AJAX
            $.ajax({
                url: '/update-session/registration-requirements/withpermission',
                type: 'POST',
                data: {
                    checked_permissions: checkedValues,
                    unchecked_permissions: uncheckedValues
                },
                success: function(response) {
                    // Handle success response
                    // console.log(response);
                    window.location.href =
                        "{{ route('registration.requirements-colorpallete') }}";
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
                }, 30);

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

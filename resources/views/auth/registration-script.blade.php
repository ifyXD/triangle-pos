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


            // $('.form-control').removeClass('is-invalid');
            // $('.invalid-feedback').text('');
            // $('.permissionForm').addClass('d-none');
            // $('.registrationForm').removeClass('d-none');


            // Serialize the form data
            var formData = $('#permissions-form').serializeArray();

            // Convert the form data to an object
            var data = {};
            $.each(formData, function(index, field) {
                data[field.name] = field.value;
            });

            // Get an array of all checkbox values (permission_ids)
            var permissionIds = $('input[name="permissions[]"]').map(function() {
                return $(this).val();
            }).get();

            // Create an array to hold all permissions with their statuses
            var permissions = [];

            // Iterate through all permission_ids and check their statuses
            $.each(permissionIds, function(index, permissionId) {
                // Check if the checkbox with this permission_id is checked
                var status = $('input[name="permissions[]"][value="' + permissionId + '"]').is(
                    ':checked');

                // Push the permission with its status to the array
                permissions.push({
                    permission_id: permissionId,
                    status: status
                });
            });

            // Send the data to the server
            $.post('/update-session/registration-requirements/withpermission', {
                    selectedElement: 'third',
                    storename: '{{ session('storename') }}',
                    id: {{ auth()->user()->id }},
                    permissions: permissions
                })
                .done(function(response) {
                    //redirect to route {{ route('registration.requirements-storename') }}
                    window.location.href = "{{ route('registration.requirements-colorpallete') }}";
                })
                .fail(function(xhr, status, error) {
                    // Handle failure
                    console.error(xhr.responseText);
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

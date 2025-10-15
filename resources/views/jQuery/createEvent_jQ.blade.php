<script>
    $(function() {
        $("#createEventForm").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);

            $.ajax({
                url: '{{ route('space_event.store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    console.log(response.message);

                    if (response.success) {
                        Swal.fire(
                            'Success',
                            response.message,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                //load the newly created event page
                                window.location.href = '{{ url('space_event/runnigEvents') }}/'+response.event_id;
                            }
                        });


                    } else {
                        console.log('Validation errors');
                        showErrors(response.message);

                    }
                }/* ,
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                    console.error(jqXHR.responseText);

                } */
            });
        });

        function showErrors(errors) {
            //let errorMessages = '';

            /* $.each(errors, function(key, value) {
                errorMessages += `<strong>${key}:</strong> ${value.join('<br>')}<br>`;
            }); */

            Swal.fire(
                'Validation Errors!',
                errors,
                'error'
            );
        }

        function errorMessage() {
            Swal.fire(
                'Error!',
                'There was an issue saving the data.',
                'error'
            );
        }
    });
</script>

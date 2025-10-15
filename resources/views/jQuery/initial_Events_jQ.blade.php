<script type="text/javascript">
    $(function() {
        // fetch all event types ajax request
        fetchAllEventTypes();

        function fetchAllEventTypes() {
            $.ajax({
                url: "{{ route('event_type.fetchAll') }}",
                method: 'get',
                success: function(response) {
                    $("#event_types").html(response);
                    $("table").DataTable({
                        order: [0, 'asc'],
                        scrollY: '50vh',
                        scrollCollapse: true,
                        paging: false,
                        info: false,
                        columnDefs: [{
                            orderable: false,
                            targets: [1, 2, 3]
                        }]
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error occoured: ".textStatus);
                    console.error(errorThrown);
                }
            });
        }

        // add new event_type ajax request
        $("#new_event_type_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#save").text('Adding...');

            $.ajax({
                url: "{{ route('event_type.store') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type
                        )
                        fetchAllEventTypes();
                    } else {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type
                        )
                    }
                    $("#save").text('Add');
                    $("#new_event_type_form")[0].reset();
                }
            });
        });

        //show dedicated image for the event type
        $(document).on('click', '.imageIcon', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');

    $.ajax({
        url: "{{ route('event_type.showImage') }}",
        method: 'get',
        data: { id: id },
        success: function(response) {
            $("#event_type_image").attr('src', response.image_path);
            $('#image-Model').modal('show');
        }
    });
});

        //show edit event_type model ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: "{{ route('event_type.edit') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#event_type_id").val(response.id);
                    $("#edit_event_type").val(response.event_type);
                    $('#editEventTypeModel').data('original-event-type', response.event_type); // Store original event type
                    $('#editEventTypeModel').modal('show');
                }
            });
        });

        // update event type ajax request
        $("#edit_event_type_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            fd.append('event_id', $('#event_type_id').val()); // Add event_id to the form data
            fd.append('original_event_type', $('#editEventTypeModel').data('original-event-type')); // Add original event type to the form data
            $("#edit_event_type_btn").text('Updating...');
            $.ajax({
                url: "{{ route('event_type.update') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type,
                        )
                        fetchAllEventTypes();
                        $("#edit_event_type_form")[0].reset();
                        $("#editEventTypeModel").modal('hide');
                    } else {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type
                        )
                    }
                    $("#edit_event_type_btn").text('Update');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error occoured: ".textStatus);
                    console.error(errorThrown);
                }
            });
        });

        // delete event type ajax request
        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('event_type.delete') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                fetchAllEventTypes();
                            } else {
                                Swal.fire(
                                    response.title,
                                    response.message,
                                    response.type
                                )
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire(
                                'Error!',
                                textStatus.message,
                                'error'
                            )
                        }
                    });
                }
            })
        });



    });
</script>
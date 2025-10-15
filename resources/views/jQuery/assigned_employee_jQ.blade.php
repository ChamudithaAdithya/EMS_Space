<script>
    //Edit logic
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');

        $.get(`/assgn_employees/edit/${id}`, function(data) {
            $('#edit_task').val(data.task_name);
            $('#evnt').val(data.event_type);

            $('#edit_employee_form').attr('action', `/assgn_employees/update/${id}`);

            // Load related tasks for selected event
            $.get(`/ajax/getemployee`, function(employees) {
                let empDropdown = $('#emp');
                empDropdown.empty();
                empDropdown.append('<option value="">-- Select Employee --</option>');
                employees.forEach(function(emp) {
                    empDropdown.append(`<option value="${emp.id}">${emp.emp_name}</option>`);
                });
                $('#emp').val(data.emp_id);
            });


            $('#editassignedEmployeeModel').modal('show');
        });
    });



    // Delete logic

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/assgn_employees/delete/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 1000,
                                showConfirmButton: false
                            });

                            // Reload the page after 1.5s
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                });
            }
        });
    });





    // Load Tasks by Event for Create form
    window.loadTasksByEvent = function() {
        let eventId = $('#event_id').val();
        if (eventId) {
            $.ajax({
                type: "GET",
                url: '{{ url("/ajax/gettaskbyevent/") }}/' + eventId,
                dataType: "json",
                success: function(data) {
                    let taskDropdown = $('#task');
                    taskDropdown.empty();
                    if (data.length > 0) {
                        taskDropdown.append('<option value="">-- Select Tasks --</option>');
                        data.forEach(function(task) {
                            taskDropdown.append(`<option value="${task.id}">${task.task_name}</option>`);
                        });
                    } else {
                        taskDropdown.append('<option value="">No tasks available</option>');
                    }
                }
            });
        }
    };
</script>
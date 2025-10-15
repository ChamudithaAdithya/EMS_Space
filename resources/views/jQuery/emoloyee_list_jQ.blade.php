<script type="text/javascript">
    $(function() {
        // add new employee ajax request
        $("#new_employee_adding").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add").text('Adding...');
            $.ajax({
                url: '{{ route('employee.store') }}',
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
                        fetchAllEmployee();
                    } else {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type
                        )
                    }
                    $("#add").text('Add');
                    $("#new_employee_adding")[0].reset();
                }
            });
        });

        //edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let emp_id = $(this).attr('id');
            $.ajax({
                url: '{{ route('employee.edit') }}',
                method: 'get',
                data: {
                    id: emp_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#employee_id").val(response.id);
                    $("#edit_employee_id").val(response.emp_id);
                    $("#edit_employee_name").val(response.emp_name);
                },
            });
        });

        //fetch all employees ajax request
        fetchAllEmployee();

        function fetchAllEmployee() {
            $.ajax({
                url: '{{ route('employee.fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#employee").html(response);
                    $("table").DataTable({
                        order: [0, 'asc'],
                        scrollY: '45vh',
                        scrollCollapse: true,
                        paging: false,
                        info: false,
                        columnDefs: [{
                            orderable: false,
                            targets: [1, 2, 3]
                        }]
                    });
                }
            });
        }

        // update employee ajax request
        $("#edit_employee_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_employee_btn").text('Updating...');
            $.ajax({
                url: '{{ route('employee.update') }}',
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
                        fetchAllEmployee();
                        $("#edit_employee_form")[0].reset();
                        $("#editEmployeeModel").modal('hide');
                    } else {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.type
                        )
                    }
                    $("#edit_employee_btn").text('Update');
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('employee.delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            fetchAllEmployee();
                        }
                    });
                }
            })
        });
    });
</script>

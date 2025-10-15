@extends('layouts.app')

@section('title', 'Registered Students')

@push('css')
    <style>
        /* Custom style for the action buttons */
        .action-buttons a {
            margin-right: 5px; /* Adjust margin for better spacing */
        }

        .action-buttons {
            width: 150px; /* Adjust the width as needed */
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <x-title>Registered Students</x-title>
        <div class="text-center">
            <!-- File Upload Form -->
            <form action="{{ route('reports.import') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="mt-4">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" accept=".xls,.xlsx" id="inputGroupFile02" name="file" required>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Student Information Form -->
        <div class="container mt-5" >
            <form id="studentForm" method="POST" action="{{ route('reports.store') }}">
                @csrf <!-- CSRF protection for POST requests -->
                <input type="hidden" id="studentId" name="student_id"> <!-- Hidden input to store the student ID for updates -->
                <div class="form-group row">
                    <label class="col-sm-3 mt-10 col-form-label" for="name">Student's Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" placeholder="Enter student's name" required id="name">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="school">School:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="school" placeholder="Enter school name" required id="school">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="contact">Contact No:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="contact" placeholder="Enter contact number" required id="contact">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="email">Email Address:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" placeholder="Enter email address" required id="email">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3"></div> <!-- Empty column for alignment -->
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                        <button type="reset" class="btn btn-danger">Clear</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Display Registered Student Information -->
        <div class="container mt-5">
            <table id="student-table" class="table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Name</th>
                        <th>School</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th class="action-buttons">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr id="student-{{ $student->id }}">
                            <td><input type="checkbox" class="student-checkbox" data-id="{{ $student->id }}"></td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->school }}</td>
                            <td>{{ $student->contact }}</td>
                            <td>{{ $student->email }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('reports.delete', ['id' => $student->id]) }}" class="btn btn-danger deleteIcon">Delete</a>
                                <a href="#" 
                                    class="btn btn-warning updateIcon" 
                                    data-id="{{ $student->id }}" 
                                    data-name="{{ $student->name }}" 
                                    data-school="{{ $student->school }}" 
                                    data-contact="{{ $student->contact }}" 
                                    data-email="{{ $student->email }}">
                                    Update
                                </a>
                            </td>
                        </tr>
                    @endforeach                
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            // Initialize DataTable
            let table = $('#student-table').DataTable({
                "autoWidth": true // Enable auto width adjustment
            });

            // Handle click event for update button
            $(document).on('click', '.updateIcon', function(e) {
                e.preventDefault();

                // Get student data from the button attributes
                let studentId = $(this).data('id');
                let name = $(this).data('name');
                let school = $(this).data('school');
                let contact = $(this).data('contact');
                let email = $(this).data('email');

                // Populate the form fields with existing data
                $('#studentId').val(studentId);
                $('#name').val(name);
                $('#school').val(school);
                $('#contact').val(contact);
                $('#email').val(email);

                // Change button text to 'Update'
                $('#saveButton').text('Update');
            });

            // Reset form to handle 'Add New' functionality
            $('#studentForm').on('reset', function() {
                $('#studentId').val('');
                $('#saveButton').text('Save');
            });

            // Handle form submission to distinguish between create and update actions
            $('#studentForm').submit(function(e) {
                e.preventDefault();

                let studentId = $('#studentId').val();
                let formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: studentId ? '{{ route('reports.update') }}' : '{{ route('reports.store') }}',
                    data: formData,
                    success: function(data) {
                        if (studentId) {
                            // Update the existing student row
                            let row = $('#student-' + studentId);
                            row.find('td:nth-child(2)').text(data.student.name);
                            row.find('td:nth-child(3)').text(data.student.school);
                            row.find('td:nth-child(4)').text(data.student.contact);
                            row.find('td:nth-child(5)').text(data.student.email);
                            
                            // Update the data attributes for the update button
                            row.find('.updateIcon').data('name', data.student.name);
                            row.find('.updateIcon').data('school', data.student.school);
                            row.find('.updateIcon').data('contact', data.student.contact);
                            row.find('.updateIcon').data('email', data.student.email);

                            Swal.fire('Success!', 'Student has been updated.', 'success');
                        } else {
                            // Add a new student row to the table
                            let newRow = table.row.add([
                                '<input type="checkbox" class="student-checkbox" data-id="' + data.student.id + '">',
                                data.student.name,
                                data.student.school,
                                data.student.contact,
                                data.student.email,
                                `<div class="action-buttons">
                                    <a href="{{ url('reports/delete') }}/` + data.student.id + `" class="btn btn-danger deleteIcon">Delete</a>
                                    <a href="#" class="btn btn-warning updateIcon"
                                       data-id="` + data.student.id + `"
                                       data-name="` + data.student.name + `"
                                       data-school="` + data.student.school + `"
                                       data-contact="` + data.student.contact + `"
                                       data-email="` + data.student.email + `">Update</a>
                                </div>`
                            ]).draw(false).node();

                            // Add an ID to the newly created row for easy referencing
                            $(newRow).attr('id', 'student-' + data.student.id);

                            Swal.fire('Success!', 'Student has been added.', 'success');
                        }

                        // Reset the form and button text
                        $('#studentForm')[0].reset();
                        $('#saveButton').text('Save');
                    },
                    error: function(error) {
                        // Display a meaningful error message
                        Swal.fire('Error!', 'Failed to save student data. Please try again.', 'error');
                        console.log('Error:', error.responseJSON);
                    }
                });
            });

            // Delete student function
            $(document).on('click', '.deleteIcon', function (e) {
                e.preventDefault();
                let url = $(this).attr('href'); // Get the delete URL
                let id = $(this).closest('tr').attr('id').replace('student-', ''); // Extract the student ID from the closest row ID

                Swal.fire({
                    title: 'Are you sure you want to delete this student?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    'Student has been deleted.',
                                    'success'
                                );
                                // Remove the deleted student row from the DOM
                                $('#student-' + id).remove();
                            },
                            error: function (error) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete student.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

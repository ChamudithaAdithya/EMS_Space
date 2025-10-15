@extends('layouts.app')

@section('title')
    Completed Events
@endsection

@section('content')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Blade Template</title>
    <style>
        .taskname {
            border: none !important;
            background: transparent !important;
            width: 100%; /* Ensure full width for the task name */
        }

        .btn-warning {
            background-color: yellow;
            color: black;
        }

        .btn-success {
            background-color: green;
            color: white;
        }

        .container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            width: 100%;
        }

        .second-title {
            text-decoration: underline;
            /* margin-bottom: 20px; Add bottom padding for spacing*/
        } 

        .section1,
        .section2 {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
        }

        .section1 {
            max-width: 40%;
        }

        .section2 {
            max-width: 60%;
        }

        table {
            width: 50%;
        }

        /* Block-level event details */
        .event-details {
            margin-bottom: 10px;
        }

        .event-details div {
            margin-bottom: 10px;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    
    <x-title class="main-title">
        Previous Event 
    </x-title>

    <x-title class="division-title">
        {{ $eventTypeName->event_type}}
    </x-title>

    

    <br/>

    <div class="container">
        <!-- Section 1: Event Organizing Details -->
        <div class="section1">
            <h4 class="text-center">Organizing Details</h4>


            <br/>

            <div class="card border-0 shadow-lg">
            <div class="card-body">

            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Event Id</th>
                        <td>{{ $completedEvent->id }}</td>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <td>{{ \Carbon\Carbon::parse($completedEvent['start_date'])->format('Y') }}</td>
                    </tr>
                    <tr>
                        <th>Event Name</th>
                        <td>{{  $completedEvent->event_name }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{  $completedEvent->start_date}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{  $completedEvent->end_date }}</td>
                    </tr>
                    <tr>
                        <th>Coordinator Id</th>
                        <td>{{  $completedEvent->coordinator }}</td>
                    </tr>
                </tbody>
            </table>

            </div>
          </div>
        </div>

        <!-- Section 2: Task List -->
        <div class="section2">
            {{-- <h4 style="font-weight: bold;">Task List</h4> --}}
            <h4 class="text-center font-weight-bold">Task List</h4>
            <br/>

            <div class="card border-0 shadow-lg">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Assigned Employee</th>
                                {{-- <th>Assigned</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Sample data
                                $tasks = [
                                    ['tasks' => 'Design the logo', 'emp_assign' => 1, 'status' => 0],
                                    ['tasks' => 'Develop the homepage', 'emp_assign' => 2, 'status' => 1],
                                    ['tasks' => 'Set up database', 'emp_assign' => null, 'status' => 0],
                                    ['tasks' => 'Create API endpoints', 'emp_assign' => 3, 'status' => 1],
                                ];
                
                                $employees = [
                                    ['emp_id' => 1, 'emp_name' => 'Alice Smith'],
                                    ['emp_id' => 2, 'emp_name' => 'Bob Johnson'],
                                    ['emp_id' => 3, 'emp_name' => 'Charlie Brown'],
                                ];
                            @endphp
                
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <input class="taskname" name="taskname" type="text" value="{{ $task['tasks'] }}" readonly>
                                    </td>
                
                                    {{-- <td>
                                        <select style="width:40%;" name="employee_id">
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee['emp_id'] }}" {{ $task['emp_assign'] == $employee['emp_id'] ? 'selected' : '' }}>
                                                    {{ $employee['emp_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-dark mt-2 add-task">Assign</button>
                                    </td> --}}
                  
                                    <td>
                                        <span class="employee_assigned" name="employee_assigned">
                                            {{ $task['emp_assign'] ? $employees[array_search($task['emp_assign'], array_column($employees, 'emp_id'))]['emp_name'] : 'Not Assigned' }}
                                        </span>
                                    </td>
                
                                    <td>
                                        {{-- <button type="button" class="btn status-button {{ $task['status'] == 1 ? 'btn-success' : 'btn-warning' }}" data-task-id="{{ $loop->index }}"> --}}
                                            {{ $task['status'] == 1 ? 'Done' : 'To do' }}
                                        {{-- </button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add task AJAX request
            
            // $(".add-task").click(function() {
            //     var taskRow = $(this).closest("tr");
            //     var taskName = taskRow.find(".taskname").val();
            //     var selectedEmployee = taskRow.find("select[name=employee_id]").val();

            //     $.ajax({
            //         url: '{{ route('assign.employee') }}',
            //         method: 'post',
            //         data: {
            //             _token: $('meta[name="csrf-token"]').attr('content'),
            //             event_name: taskName,
            //             employee_id: selectedEmployee
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             console.log(response);
            //             if (response.success) {
            //                 alert("Employee assigned successfully.");
            //                 taskRow.find('.employee_assigned').text(response.employee_name);
            //             } else {
            //                 alert("Error: " + response.message);
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //             alert("An error occurred. Please try again.");
            //         }
            //     });
            // });

            // Update task status
            $('.status-button').click(function() {
                const button = $(this);
                const taskId = button.data('task-id');

                $.ajax({
                    url: '{{ route('update.task.status') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        task_id: taskId,
                    },
                    success: function(response) {
                        if (response.success) {
                            if (button.text() === 'To do') {
                                button.text('Done');
                                button.removeClass('btn-warning').addClass('btn-success');
                            } else {
                                button.text('To do');
                                button.removeClass('btn-success').addClass('btn-warning');
                            }
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>


@endsection

@extends('layouts.app')

@section('title') Assigned Employee List @endsection

@section('content')
<div class="container p-3 mb-3" style="min-height: 80vh;">
    <x-title>Assigned Employee List</x-title>
    <div class="d-flex justify-content-between py-3">
        <div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignedEmployeeModel">
                <i class="bi bi-database-add"></i> Create
            </button>
        </div>
    </div>

     @if(Session::has('success'))
            <script>
                Swal.fire(
                    'Success!',
                    'Event Created Successfully!',
                    'success'
                );
            </script>
        @endif

    <div class="card border-0 shadow-lg">
        <div class="card-body">
            <table class="table table-striped" id="assigned_employee_table">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Assigned Task</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assignTask as $ass)
                    <tr>
                        <td width="28%">{{ $ass['event_type'] }}</td>
                        <td>{{ $ass['task_name'] }}</td>
                        <td colspan="3" style="padding: 0px; width:52%">
                            <div>
                                <table class="table" style="margin-bottom: 0px; width: 100%">
                                    @foreach ($ass['employees'] as $emp)
                                    <tr style="border: beige;">
                                        <td width="25%">{{ $emp['emp_id'] }}</td>
                                        <td width="50%">{{ $emp['emp_name'] }}</td>
                                        <td width="25%">
                                            <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="{{ $emp['id'] }}" data-bs-toggle="modal" data-bs-target="#editassignedEmployeeModel">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $emp['id'] }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="assignedEmployeeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="create_assigned_employee_form" method="POST" action="{{ route('assgn_employees.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">

                    <div class="mb-3">
                        <label>Event</label>
                        <select id="event_id" name="event_id" class="form-control" required onchange="loadTasksByEvent()">
                            <option value="">-- Select Event --</option>
                            @foreach ($event as $ev)
                            <option value="{{ $ev->id }}">{{ $ev->event_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="col-lg">
                            <label for="assignedemptask">Task</label>
                            <select name="task" id="task" class="form-control" required>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Employee Name</label>
                        <select name="emp_id" class="form-control" required>
                            <option value="">-- Select Employee --</option>
                            @foreach ($employee as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->emp_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit" id="assign_btn">Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editassignedEmployeeModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="edit_employee_form" method="POST" action="#">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Assign Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="mb-3">
                        <div class="col-lg">
                            <label>Task</label>
                            <input type="text" id="edit_task" name="task" class="form-control" readonly>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Event</label>
                        <input type="text" id="evnt" name="evnt" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Employee Name</label><br>
                        <select name="emp" class="form-control" required id="emp">
                            <option value="">-- Select Employee --</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit" id="assign_btn">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

{{-- jQuery for the table --}}


@push('js')
@include("jQuery.assigned_employee_jQ")
@endpush
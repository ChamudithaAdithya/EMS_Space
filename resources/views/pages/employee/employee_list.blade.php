<!-- Layout -->
@extends('layouts.app')

@section('title')
    Employee List
@endsection

@push('css')
<style>
    /* Remove both horizontal and vertical scrollbars */
    body {
        overflow: hidden;
    }

    /* Disable vertical scrolling for the container */
    .container {
        overflow-y: hidden;
    }
</style>
@endpush

@section('content')
    <!-- Body Content -->
    <x-title>Employees</x-title>

    <div class="container p-3 mb-3" style="min-height: 80vh;">
        <div class="d-flex justify-content-between py-3">
        </div>

        <div class="row">

            {{-- table --}}
            <div class="col-12 col-md-7 order-last order-md-first ">
                <div class="" style="height: 50vh;">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body" id="employee">
                            {{-- Employee table goes inside here --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- form --}}
            <div class="col-12 col-md-5 mt-4 order-first order-md-last mb-4 mb-md-0">
                <div>
                    <div class="card border-0">
                        <form id="new_employee_adding" action="#" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card border-0 shadow-lg p-3">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class='bx bx-add-to-queue'></i>
                                        Add New Employee
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="emp_id" class="form-label">Employee ID</label>
                                        <input type="text" name="emp_id" id="emp_id" placeholder="Enter Employee ID"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="emp_name" class="form-label">Employee Name</label>
                                        <input type="text" name="emp_name" id="emp_name"
                                            placeholder="Enter Employee Name" required class="form-control" required>
                                    </div>
                                    <x-submit-btn class="mt-3 float-end" id="add">Add
                                    </x-submit-btn>
                                    <x-reset-btn class="mt-3 mx-2 float-end"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Edit Employee modal --}}
            <div class="modal fade" id="editEmployeeModel" tabindex="-1" aria-labelledby="exampleModalLabel"
                data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="#" method="post" id="edit_employee_form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4 bg-light">
                                <div class="col-lg">
                                    <label for="edit_employee_id">Employee ID</label>
                                    <input type="text" name="emp_id" id="employee_id" hidden="true">
                                    <input type="text" name="edit_employee_id" id="edit_employee_id" class="form-control"
                                        placeholder="Enter Employee id" required>
                                </div>
                                <div class="col-lg">
                                    <label for="edit_employee_name">Employee Name</label>
                                    <input type="text" name="edit_employee_name" id="edit_employee_name"
                                        class="form-control" placeholder="Enter Employee name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="edit_employee_btn" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- jQuery for the table --}}
@push('js')
    @include("jQuery.emoloyee_list_jQ")
@endpush

@extends('layouts.app')

@section('title')
    Tasks per Event
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- CSRF token --}}

    <x-title class="mb-4">Tasks of {{ $event->event_type }}</x-title>

    {{-- <div class=""> --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 mb-3">
                <button id="addTasksBtn" class="d-inline float-end btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addTasksModal">Add
                    Tasks</button>
            </div>
        </div>

        {{-- tasks table --}}
        <div class="row justify-content-center h-25">
            <div class="col-10 mx-4 parent" style="height: 55vh;">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-body h-100" id="tasks">
                        <!-- tasks table loads here -->
                    </div>
                </div>
            </div>
        </div>

        {{-- task name edit model --}}
        <div class="modal fade" id="editTaskNameModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Event Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="post" id="editTaskNameForm">
                        @csrf
                        <input type="hidden" name="task_id" id="task_id">
                        <input type="hidden" name="event_type_id" id="event_type_id">
                        <div class="modal-body p-4 bg-light">
                            <div class="row">
                                <div class="col-12">
                                    <label for="taskName">Event Type</label>
                                    <input type="text" name="taskName" id="taskName" class="form-control"
                                        placeholder="Enter Event Type" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <x-submit-btn class="float-end " id="update" name="update">Update</x-submit-btn>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- attachment add button input --}}
        <input type="file" id="fileInput" multiple hidden>

    </div>

    {{-- create new  tasks modal --}}
    <x-add-tasks-modal labelledby="addTasksBtn" title="New Task" formId="Modal_new_event_type_form" action="#" cardTitle="Create New Task"/>

    {{-- css for the table --}}
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/task_table.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    @endpush
    {{-- jQuery for the table --}}
    @push('js')
        @include('jQuery.tasks_per_event_jQ', [
            'eventId' => $event->id,
        ])
    @endpush
@endsection

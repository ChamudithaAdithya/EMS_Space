@extends('layouts.app')

@section('title')
    Create New Event
@endsection

@section('content')

    <div class="container p-5 mb-3" style="min-height: 80vh;">
        <h1 style="font-family: 'Times New Roman', Times, serif; text-align: center;">
            Create New Event
        </h1>

        <!-- Back button aligned with form -->
        <div class="w-50 mx-auto py-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- Event Creation Form -->
        <div class="card w-50 mx-auto mb-4" style="height: 70vh">
            <div class="card-body shadow-lg" style="width: 100%; overflow-y: auto">
                <form action="#" id="createEventForm" method="POST" class="needs-validation">
                    @csrf

                    <div class="mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" name="event_name" id="event_name" class="form-control"
                               placeholder="Enter Event Name" value="{{ $eventName }}" required>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <input type="hidden" name="event_type_id" id="event_type_id" value="{{ $id }}">

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="coordinator" class="form-label">Select Coordinator</label>
                        <select name="coordinator" id="coordinator" class="form-select">
                            <option value="0" selected>--Select Coordinator--</option>
                            @foreach ($coordinators as $coordinator)
                                <option value="{{ $coordinator->id }}">
                                    {{ $coordinator->emp_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tasks</label>
                        @foreach ($tasklist as $task)
                            <div>
                                <input type="checkbox" class="form-check-input" id="task{{ $task->id }}" name="tasks[]" value="{{ $task->id }}">
                                <label class="fs-5" for="task{{ $task->id }}">{{ $task->task_name }}</label><br>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-2" style="height: 6vh">
                        <x-reset-btn class="mt-3 mb-2 mx-1 float-end" />
                        <x-submit-btn class="mt-3 mb-2 mx-1 float-end" type="submit">Submit</x-submit-btn>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('js')
    @include('jQuery.createEvent_jQ')
@endpush

<!-- Layout -->
@extends('layouts.app')

@section('title')
    Events
@endsection

@section('content')
    <!-- Body Content -->
    <div class="container p-3 mb-3" style="min-height: 80vh;">

    <x-title>Initial Events</x-title>

    <div class="container h-50 d-flex align-items-center justify-content-center">

        {{-- table --}}
        <div class="col-10">
            <div class="" style="height: 50vh;">
                <div class="card border-0 shadow-lg">
                    <div class="card-body" id="event_types">
                        {{-- event types table is load here --}}
                    </div>
                </div>
            </div>
        </div>


        {{--  Edit event_type modal --}}
        <div class="modal fade" id="editEventTypeModel" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Event Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="post" id="edit_event_type_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_id" id="event_type_id">
                        <div class="modal-body p-4 bg-light">
                            <div class="row">
                                <div class="col-12">
                                    <label for="edit_event_type">Event Type</label>
                                    <input type="text" name="edit_event_type" id="edit_event_type" class="form-control"
                                        placeholder="Enter Event Type" required>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="edit_event_type_image">Image</label>
                                    <input type="file" name="edit_event_type_image" id="edit_event_type_image"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="edit_event_type_btn" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Show event model's image --}}
        <div class="modal fade" id="image-Model" tabindex="-1" data-bs-backdrop="true" aria-hidden="true"
            aria-labelledby="imageModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                        <img src="" id="event_type_image" class="img-fluid" alt="Loading...">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- jQuery for the table --}}
@push('js')
    @include('jQuery.initial_Events_jQ')
@endpush

@push('css')
    <style>
        label {
            font-weight: 500;
        }
    </style>
@endpush

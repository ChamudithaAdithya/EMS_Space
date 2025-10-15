<!-- Layout -->

{{-- @ DESCRIPTION      => SpaceEventCreate blade
 @ ENDPOINT         =>space event create controller
 @ ACCESS           => all members in space section
 @ CREATED BY       => Harindu Ashen
 @ CREATED DATE     => 2024/06/26  --}}

@extends('layouts.app')

@section('title')
    Events
@endsection

@section('content')
   <!-- Body Content -->
   <div class="container p-3 mb-3" style="min-height: 80vh;">

   <x-title>New Event Type</x-title>

    <div class="container-fluid h-50 d-flex justify-content-center ">
        {{-- form --}}
        <div class="col-6 align-self-center">
            <div>
                <div class="card border-0">
                    <form id="new_event_type_form" action="#" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card border-0 shadow-lg p-3">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class='bx bx-add-to-queue'></i>
                                    Create New Event Type
                                </h5>
                            </div>
                            <div class="card-body">

                            <div class="mb-3">
                                <label for="event_type" class="form-label">Event Name</label>
                                <input type="text" name="event_type" id="event_type" placeholder="Enter Event Type"
                                        class="form-control" required>

                                <label for="image" class="form-label mt-4">Event Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            {{-- Buttons --}}

                                <x-submit-btn class="mt-3 float-end ms-2" id="save" name="submit" >Add</x-submit-btn>
                                <x-reset-btn class="mt-3 float-end" />
                                
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
{{-- endsection--}}
  {{-- create new  tasks modal --}}
 <x-add-tasks-modal labelledby="exampleModalLabel" title="New Task" action="#" cardTitle="Create New Task"/>

@endsection


@push('js')
    @include('jQuery.space_event_create_jQ')
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('css/create_space_event.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endpush

@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .scroll {
        overflow-x: auto;
        white-space: nowrap;
    }

    .card-hover {
        display: inline-block;
        margin: 10px;
    }

    .card-image {
        width: 100%;
        height: auto;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="intro">
        <x-title>
            Event Management System of <br>The Space Astronomy Division
        </x-title>

        <h3>
            The system streamlines event organization effortlessly.
            Upcoming events and associated tasks are presented with ease, facilitating coordination.
        </h3>
    </div>

    <div class="row">
        <div class="scroll">
            @foreach ($new_event as $event)

            <div class="col-md-4 mb-8">
                <div class="col-sm-md-lg-3 card-hover">
                    @if(isset($event->eventType->img_path) && $event->eventType->img_path)
                    <x-cardimage
                        imageUrl="{{ asset('storage/'.$event->eventType->img_path) }}"
                        imageAlt="{{ $event->event_name }}"
                        title="{{ $event->event_name }}"
                        content="{{ $event->description }}"
                        sdate="{{ $event->start_date }}"
                        edate="{{ $event->end_date }}"
                        eid="{{ $event->id }}" />
                    @else
                    @endif

                </div>

            </div>
            @endforeach

        </div>

    </div>
</div>
@endsection

@push('js')
<script>
    var scrollContainer = document.querySelector('.scroll');
    var scrollStep = 350; // Adjust as needed for card width or spacing

    function scrollLeft() {
        scrollContainer.scrollLeft -= scrollStep;
    }

    function scrollRight() {
        scrollContainer.scrollLeft += scrollStep;
    }
</script>
@endpush
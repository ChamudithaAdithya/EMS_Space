<!DOCTYPE html>
@extends('layouts.app')
@section('title', 'Edit Report')
@section('content')

<style>
    /* Global body styling */
    body {
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        padding: 0;
        overflow: hidden; /* Prevent scrolling */
    }

    /* Main container for a full page layout */
    .container {
        display: flex;
        flex-direction: row;
        height: 100vh; /* Full height of the viewport */
        width: 100vw; /* Full width of the viewport */
        box-sizing: border-box;
        padding: 0 20px;
    }

    /* Sidebar for activities */
    .sidebar {
        flex-direction: row;
        padding: 20px;
        background-color: #ffffff;
        border-right: 1px solid #ddd;
        box-sizing: border-box;
        overflow-y: auto; /* Allow scrolling only for this section if content overflows */
    }

    /* Content area for AJAX results */
    .content-container {
        flex: 3;
        padding: 20px;
        background-color: #f3f3f3;
        box-sizing: border-box;
        overflow-y: auto; /* Allow scrolling only for this section if content overflows */
    }

    /* Style for the main title */
    .main-title-container {
        display: flex;
        justify-content: center; /* Center both titles horizontally */
        align-items: center; /* Align items vertically in the center */
        padding: 20px;
        
    }

    .main-title {
        color: darkblue;
        font-weight: bold;
        text-decoration: underline; /* Underline for Event Type */
        margin-right: 20px; /* Add some spacing between the titles */
    }

    .division-title {
        color: darkblue;
        font-weight: bold;
    }

    /* Activity list styling */
    /* .event {
        display: inline-block;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #0AD1C8;
        background-color: #7f7e7e;
        color: #fdfdfd;
        text-decoration: underline; 
        border-radius: 5px;
        cursor: pointer;
        width: 100%; 
    } */

    /* Highlight the active event */
    .event.active {
        background-color: #0AD1C8;
    }

    /* AJAX content styling */
    #ajaxResults {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        min-height: 200px; /* Ensure a minimum height for the content */
    }
</style>

<!-- Titles in the same line -->
<div class="main-title-container">
    
    <x-title class="main-title">
        {{ $eventType->event_type }}
    </x-title>

    <x-title class="division-title">
        Event Organizing by Space Application Division
    </x-title>

</div>

<div class="container">
    <!-- Sidebar (Activities List) -->
    {{-- <div class="sidebar"> --}}
        <div>
            @foreach ($eventname as $event)
            <a ref="event" class="event" data-no="{{ $event->id }}">
                {{-- {{ $event->event_name }} --}}
            </a>
            @endforeach


            @foreach ($eventinstancetasks as $eventinstancetask)
            {{-- <a ref="event" class="event" data-no="{{ $event->id }}"> --}}
                {{ $eventinstancetask->task_name }}
            {{-- </a> --}}
            @endforeach

        {{-- </div> --}}
    </div>

    <!-- Main Content Area (AJAX results) -->
    <div class="content-container">
        <div class="content" id="ajaxResults">
            <!-- AJAX content will load here -->
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        // Event click handling
        $('a[ref="event"]').click(function() {
            var id = $(this).attr("data-no");

            // Set active class on clicked event
            $('a[ref="event"]').removeClass('active');
            $(this).addClass('active');
            
            $.ajax({
                type: 'get',
                url: '{{url("/space_event/view/")}}/' + id,
                data: {},
                dataType: 'json',
                success: function(data) {
                    $('#ajaxResults').html(data.html);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response
                }
            });
        });

        // Initially trigger the click on the first event
        $('a.event:first').click();
    });
</script>

@endsection

@section('script')
@endsection

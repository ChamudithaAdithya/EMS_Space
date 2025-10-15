@extends('layouts.app')

@section('title')
Create New Events
@endsection

@section('content')
<style>
    thead {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    thead th {
        text-decoration: underline;
    }

    #sticky-header {
        position: sticky;
        top: 0;
        background-color: rgb(234, 243, 250);
        z-index: 1;
    }

    .disabled-active-btn {
        padding: 5px 10px;
        background-color: #656565;
        color: white;
        border: none;
        border-radius: 4px;
        pointer-events: none;
    }

    .enabled-active-btn {
        padding: 5px 10px;
        background-color: #0aa17d;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .enabled-active-btn:hover {
        background-color: #086e56;
        color: white;
    }

    .create-new-class {
        padding: 5px 10px;
        background-color: #190575;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .create-new-class:hover {
        background-color: #04043d;
        color: white;
    }

    /* Basic styling for the dropdown */
.dropdown {
  position: relative;
  display: inline-block;
  width: 200px; /* adjust width */
}

.dropdown-btn {
  background-color: #0a8028ff;
  color: white;
  padding: 8px 12px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  width: 100%;
  text-align: left;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: white;
  min-width: 220px;
  max-height: 200px; /* limits height */
  overflow-y: auto; /* scroll if content exceeds max height */
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  margin-top: 4px;
  border-radius: 4px;
  padding: 5px 0;
}

.dropdown-content div {
  padding: 5px 15px;
  cursor: pointer;
}

.dropdown-content div:hover {
  background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
  display: block;
}


</style>

<div class="container p-3 mb-3" style="min-height: 80vh;">

    <x-title>Manage Events</x-title>

    <div class="container mt-2" style="margin: 0 auto; background-color:white">

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table class="table table-striped " id="eventsTable">
                    <thead>
                        <tr>
                            <th class="column-header text-left">Event</th>
                            <!-- <th class="column-header text-center">Previous Event</th> -->
                            <th class="column-header text-center">Create Event</th>
                            <th class="column-header text-center">Running Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                        {{-- disabled button and normal button logic --}}
                        @php
                        $runningCount = $event->event_types
                        ->where('event_type_id', $event->id)
                        ->where('active_status', 'running')
                        ->count();
                        $completedCount = $event->event_types
                        ->where('event_type_id', $event->id)
                        ->where('active_status', 'completed')
                        ->count();
                        $runningStatCheck = $runningCount == 0 ? false : true;
                        $completedStatCheck = $completedCount == 0 ? true : false;
                        $buttonStyle =
                        $event->event_types->isEmpty() || $completedStatCheck
                        ? 'disabled-active-btn'
                        : 'enabled-active-btn';
                        $setupUrl =
                        $event->event_types->isEmpty() || $completedStatCheck
                        ? ''
                        : 'space_event/completedEvents/' . $event->id;
                        @endphp

                        {{-- table content --}}
                        <tr valign="middle">
                            <td style="border: 0px; padding: 10px; text-align:left">{{ $event->event_type }}</td>
                            <!-- <td style="border: 0px; padding: 10px; text-align:center">

                                <a href="{{ $setupUrl }}" class="btn {{ $buttonStyle }} rounded">
                                    View Activities
                                </a>
                            </td> -->
                            <td style="border: 0px; padding: 10px; text-align:center">
                                        <form action="{{ route('space_event.create') }}" method="GET"
                                            data-sb-form-api-token="your-api-token">
                                            @csrf
                                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                                            <button type="submit" class="create-new-class">
                                                Create New
                                            </button>
                                        </form>
                                    </td>


                            <td style="border: 0px; padding: 10px; text-align:center">
                                @if ($event->event_types->isEmpty() || !$runningStatCheck)
                                <div style="text-align: center; width: 30vh; margin: auto;">
                                    No running events
                                </div>
                                @else
                                <div class="dropdown">
                                    <button class="dropdown-btn">Show Events <i class='bx bx-chevron-down'
                                            style="margin-top: 8px;margin-left:5px"></i></button>
                                     <div class="dropdown-content">
                                    @foreach ($event->event_types->where('active_status', 'running') as $event_instance)
                                   <div style="display: flex; justify-content: space-between; align-items: center; padding: 1px 10px;">
                                 <a href="{{ route('space_event.runnigEvents', ['newEventId' => $event_instance->id]) }}">
                                {{ $event_instance->event_name }}
                                 </a>
                                   <button class="btn btn-sm btn-danger delete-btn" 
                                    data-id="{{ $event_instance->id }}" 
                                    style="background: red; border: red; color: white; font-weight: bold; cursor: pointer;" 
                                    title="Delete Event">
                                &times;
                            </button>
                        </div>
                        @endforeach
                      </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('jQuery.event_type_jQ')
    </div>

    <!-- Modal -->



@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.view-events-btn').click(function() { // Added '.' before 'view-events-btn'
            {
                {
                    var eventId = $(this).data('event-id');
                }
            }
            console.log('kjh');
            $.ajax({
                url: '/space_events/' + eventId,
                type: 'GET',
                success: function(response) {
                    // Handle success response and update UI with event details
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

    });
</script>
@endsection
@extends('layouts.app')

@section('title')
    Completed Events
@endsection

@push('css')
    <style>
        body{
            overflow: hidden;
        }
    </style>

@endpush
@section('content')
    <x-title class="main-title">Completed Events Of <br> {{ $eventTypeName->event_type}}</x-title>

    <div class="card w-50 mx-auto mb-5">
        <div class="card-body" style="height: 60vh;">
            <table class="table table-striped align-middle" id="event_types" >

                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Event Name</th>
                        <th class="text-center">Started Year</th>
                        <th class="text-center">View More</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($completedEvents as $completedEvent)
                        @php
                            $date= $completedEvent->start_date;
                            $year = Carbon\Carbon::parse($date)->year;
                        @endphp
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <th class="text-center">{{ $completedEvent->event_name }}</th>
                            <th class="text-center">{{ $year }}</th>
                            <th class="text-center">
                                <a href="{{ route('space_event.completedEvents.completedEvent', ['eventTypeId' => $completedEvent->id]) }}"
                                    class="btn btn-success rounded">
                                    View Event
                                </a>

                            </th>
                        </tr>
                    @endforeach
                </tbody>
              </table>
           </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $("#event_types").DataTable({
                order: [0, 'asc'],
                scrollY: '46vh',
                scrollCollapse: true,
                paging: false,
                info: false,
                columnDefs: [{
                    orderable: false,
                    targets: [1, 3]
                }]
            });
        });
    </script>
@endsection

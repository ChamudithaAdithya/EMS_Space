<!-- Layout -->

{{-- @ DESCRIPTION      => SpaceEventCreate blade
 @ ENDPOINT         =>space event create controller
 @ ACCESS           => all members in space section
 @ CREATED BY       => Harindu Ashen,Diuth
 @ CREATED DATE     => 2024/06/26  --}}

@extends('layouts.app')

@section('title')
    Events
@endsection

@section('content')
    <style>
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #5f68e2;
            width: 12%;
            margin-top: 20px;
            margin-left: 20px;
            border: #5f68e2;
            box-shadow: #ddd
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: #5f68e2;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
        .card1{
            width: 30rem;


        }
    </style>
    <!-- Body Content -->
    <x-title>Create Initial event</x-title>
    <!-- Tab links -->
    <div class="tab">
        <a href="{{ url('/event_create') }}" class="tablinks"><button>Step 1</button></a>
        <a href="{{ url('/event_form') }}" class="tablinks"><button>Step 2</button></a>
    </div>






    <div class="container-fluid h-50 d-flex justify-content-center ">
        {{-- form --}}
        <div class="row">
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
                                        <label for="event_type" class="form-label">Task</label>
                                        <input type="text" name="event_type" id="event_type"
                                            placeholder="Enter Event Type" class="form-control" required>
                                        <label for="event_type" class="form-label">Attachment</label>
                                        <input type="file" name="event_type" id="event_type"
                                            placeholder="Enter Event Type" class="form-control" required>
                                    </div>
                                    {{-- Buttons --}}
                                    <x-submit-btn class="mt-3 float-end ms-2" id="save">create</x-submit-btn>
                                    <x-cancel-btn class="mt-3 float-end" />
                                    <x-reset-btn class="mt-3 float-end ms-2" style="margin-right: 10px;" />
                                </div>



                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6 " style="margin-top: 30px;background-color:">
                <div class="card" style="  height: 10rem;">
                    <div class="card-body">
                        {{--  <h5 class="card-title">Special title treatment</h5>
                      <p class="card-text">With supporting text below as a natural lead-in to additional content. --}}
                        <table padding="10%">
                            <tr>
                                <td>ID</td>
                                <td>Tasks</td>
                                <td> </td>
                                <td>Data</td>

                            </tr>

                            <tr>
                                <td>....</td>
                                <td>....</td>
                                <td> <x-submit-btn class="mt-3 float-end ms-2" id="save">Upload</x-submit-btn> </td>
                                <td>.....</td>

                            </tr>
                        </table>
                        {{-- Buttons --}}



                    </div>
                </div>
            </div>
        @endsection

        @push('js')
            <script>

                $(function() {

                    // add new event_type ajax request
                    $("#new_event_type_form").submit(function(e) {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $("#save").text('Adding...');

                        $.ajax({
                            url: '{{ route('event_type.store') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        response.type
                                    )
                                    fetchAllEventTypes();
                                } else {
                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        response.type
                                    )
                                }
                                $("#save").text('Add');
                                $("#new_event_type_form")[0].reset();
                            }
                        });
                    });

                    // edit event_type ajax request
                    $(document).on('click', '.editIcon', function(e) {
                        e.preventDefault();
                        let id = $(this).attr('id');
                        $.ajax({
                            url: '{{ route('event_type.edit') }}',
                            method: 'get',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $("#event_type_id").val(response.id);
                                $("#edit_event_type").val(response.event_type);
                            }
                        });
                    });

                    // update event type ajax request
                    $("#edit_event_type_form").submit(function(e) {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $("#edit_event_type_btn").text('Updating...');
                        $.ajax({
                            url: '{{ route('event_type.update') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        response.type,
                                    )
                                    fetchAllEventTypes();
                                    $("#edit_event_type_form")[0].reset();
                                    $("#editEventTypeModel").modal('hide');
                                } else {
                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        response.type
                                    )
                                }
                                $("#edit_event_type_btn").text('Update');
                            }
                        });
                    });

                    // delete event type ajax request
                    $(document).on('click', '.deleteIcon', function(e) {
                        e.preventDefault();
                        let id = $(this).attr('id');
                        let csrf = '{{ csrf_token() }}';
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '{{ route('event_type.delete') }}',
                                    method: 'delete',
                                    data: {
                                        id: id,
                                        _token: csrf
                                    },
                                    success: function(response) {
                                        Swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                        )
                                        fetchAllEventTypes();
                                    }
                                });
                            }
                        })
                    });

                    // fetch all event types ajax request
                    fetchAllEventTypes();

                    function fetchAllEventTypes() {
                        $.ajax({
                            url: '{{ route('event_type.fetchAll') }}',
                            method: 'get',
                            success: function(response) {
                                $("#event_types").html(response);
                                $("table").DataTable({
                                    order: [0, 'asc'],
                                    scrollY: '50vh',
                                    scrollCollapse: true,
                                    paging: false,
                                    info: false,
                                });
                            }
                        });
                    }

                });
            </script>
        @endpush

        @push('css')
            <style>
                label {
                    font-weight: 500;
                }
            </style>
        @endpush

@extends('layouts.app')

@section('title')

    @section('title')Settings @endsection

@section('content')

    @push('css')
        <style>
            body {
                overflow: hidden;
            }

            .body-content {
                overflow-y: scroll;
                height: 81vh;
            }
        </style>
    @endpush
    <div class="body-content">

        <x-title>Settings</x-title>
        <div class="container profile-container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-8">
                    <div class="card mt-4">
                        <h4 class="card-header">
                            Change Email
                        </h4>
                        <form id="changeUserEmailForm" action="">
                            @csrf
                            <div class="card-body ">
                                <div class="form-group">
                                    <label class="form-label" for="current-email">Current Email</label>
                                    <input class="form-control" type="email" name="current-email" id="current-email"
                                        required>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label" for="new-email">New Email</label>
                                    <input class="form-control" type="email" name="new-email" id="new-email" required>
                                </div>
                                <div class="form-group mt-3 d-flex justify-content-end">
                                    <x-reset-btn class="me-2" />
                                    <x-submit-btn>Proceed</x-submit-btn>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center mb-4 pb-4">
                <div class="col-8 mb-4 pb-4">
                    <div class="card mt-4">
                        <h4 class="card-header">
                            Change Password
                        </h4>
                        <form id="changeUserPasswordForm" action="">
                            @csrf
                            <div class="card-body ">
                                <div class="form-group">
                                    <label class="form-label" for="current-password">Current Password</label>
                                    <input class="form-control" type="password" name="current-password"
                                        id="current-password">
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label" for="newPassword">New Password</label>
                                    <input class="form-control" type="password" name="newPassword" id="newPassword">
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label" for="newPassword_confirmation">Confirm New Password</label>
                                    <input class="form-control" type="password" name="newPassword_confirmation"
                                        id="newPassword_confirmation">
                                </div>
                                <div class="form-group mt-3 d-flex justify-content-end">
                                    <x-reset-btn class="me-2" />
                                    <x-submit-btn>Proceed</x-submit-btn>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#changeUserEmailForm').submit(function(e) {
                    e.preventDefault();
                    let currentEmail = $('#current-email').val();
                    var newEmail = $('#new-email').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('user_profile.settings.changeUserEmail') }}',
                        data: {
                            'currentEmail': currentEmail,
                            'newEmail': newEmail,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success!',
                                    response.message,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error occoured: ".textStatus);
                            console.error(errorThrown);
                        }
                    });
                });

                $('#changeUserPasswordForm').submit(function(e) {
                    e.preventDefault();
                    let currentPassword = $('#current-password').val();
                    let newPassword = $('#newPassword').val();
                    let confirmNewPassword = $('#newPassword_confirmation').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('user_profile.settings.changeUserPassword') }}',
                        data: {
                            'currentPassword': currentPassword,
                            'newPassword': newPassword,
                            'newPassword_confirmation': confirmNewPassword,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Success!',
                                    response.message,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error occoured: ".textStatus);
                            console.error(errorThrown);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

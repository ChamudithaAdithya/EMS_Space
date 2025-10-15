@extends('layouts.app')

{{-- @ DESCRIPTION      => invitations
 @ ENDPOINT         => InvitationController.php
 @ ACCESS           => all members in space section
 @ CREATED BY       => Harindu Ashen
 @ CREATED DATE     => 2024/06/27 --}}

@section('title')Reports @endsection

@section('content')

    <div class="container p-3 mb-3" style="min-height: 80vh;">

    <x-title>Invitations</x-title>

    <center>
        <div class="col-6">
            <form action="{{ route('send.email') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="sender_email">Sender's Email:</label>
                    <input type="email" name="sender_email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="receiver_email">Receiver's Email:</label>
                    <input type="email" name="receiver_email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" class="form-control" required></textarea>
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Send Email</button>
            </form>
        </div>
    </center>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>

</div>
@endsection

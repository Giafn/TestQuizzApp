@extends('layouts.app')

@section('title', 'Profile')
@section('content')
<div class="text-center">
    <img src="https://api.dicebear.com/9.x/dylan/svg?seed={{ $user->name }}" alt="Profile" class="rounded-pill w-100 border border-white" style="max-width: 100px">
    <h4 class="mt-3 text-white fw-bold">{{ $user->name }}</h4>
    <p class="text-white">{{ $user->email }}</p>
</div>
<div class="text-center text-white">
    @if (Auth::user()->hasVerifiedEmail())
        <p class="fw-bold mb-0">Your email has been verified.</p>
    @else
        <p class="mb-1 rounded fw-bold text-danger bg-white">Your email has not been verified.</p>
        <a href="{{ route('verification.notice') }}" class="text-white">Click here to verify your email.</a>
    @endif
</div>

{{-- update email password --}}
<div class="mt-3">
    <h5 class="fw-bold text-white">Update Email & Password</h5>
    <form method="POST" action="/profile/update">
        @csrf
        @method('PUT')
        {{-- name --}}
        <div class="mb-3">
            <input id="name" type="text" class="form-control" value="{{ $user->name }}" required autocomplete="name" placeholder="Name" autofocus>
            <div id="error_name"></div>
        </div>
        <div class="mb-3">
            <input id="email" type="email" class="form-control" value="{{ $user->email }}" required autocomplete="email" placeholder="Email" autofocus>
            <div id="error_email"></div>
        </div>
        {{-- password --}}
        <div class="mb-3">
            <input id="new_password" type="password" class="form-control" required placeholder="New Password">
            <div id="error_new_password"></div>
        </div>
        <div class="mb-3">
            <input id="confirm_password" type="password" class="form-control" required placeholder="Confirm Password">
            <div id="error_confirm_password"></div>
        </div>
    </form>
    <button id="openModalConfirmUpdate" class="btn btn-light d-block w-100 fw-bold text-primary mb-3">
        {{ __('Update') }}
    </button>

    <button id="openModalConfirmLogout" class="btn btn-danger d-block w-100 fw-bold">
        {{ __('Logout') }}
    </button>
</div>

{{-- modal --}}
<div class="modal fade" id="modalConfirmUpdate" tabindex="-1" aria-labelledby="modalConfirmUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p>
                    Please confirm your password to update your profile.
                </p>
                <input id="current_password" type="password" class="form-control" required placeholder="Password">
                <div id="error_current_password"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="confirmSubmit" type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="modalConfirmLogout" tabindex="-1" aria-labelledby="modalConfirmLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <form id="formLogout" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="confirmLogout" class="btn btn-danger">Confirm</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#openModalConfirmUpdate').click(function() {
        $('#modalConfirmUpdate').modal('show');
    });

    $('#openModalConfirmLogout').click(function(e) {
        e.preventDefault();
        $('#modalConfirmLogout').modal('show');
    });

    $('#confirmLogout').click(function() {
        $('#formLogout').submit();
    });

    $('#confirmSubmit').click(function() {
        $.ajax({
            url: '/profile/update',
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                email: $('#email').val(),
                new_password: $('#new_password').val(),
                confirm_password: $('#confirm_password').val(),
                current_password: $('#current_password').val()
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#modalConfirmUpdate').modal('hide');
                    location.reload();
                } else {
                    if (response.data.name) {
                        $('#error_name').html(response.data.name[0]);
                        $('#error_name').addClass('text-danger text-xs');
                    } else {
                        $('#error_name').html('');
                    }
                    if (response.data.email) {
                        $('#error_email').html(response.data.email[0]);
                        $('#error_email').addClass('text-danger text-xs');
                    } else {
                        $('#error_email').html('');
                    }
                    if (response.data.new_password) {
                        $('#error_new_password').html(response.data.new_password[0]);
                        $('#error_new_password').addClass('text-danger text-xs');
                    } else {
                        $('#error_new_password').html('');
                    }
                    if (response.data.confirm_password) {
                        $('#error_confirm_password').html(response.data.confirm_password[0]);
                        $('#error_confirm_password').addClass('text-danger text-xs');
                    } else {
                        $('#error_confirm_password').html('');
                    }
                    if (response.data.current_password) {
                        $('#error_current_password').html(response.data.current_password[0]);
                        $('#error_current_password').addClass('text-danger text-xs');
                    } else {
                        $('#error_current_password').html('');
                    }
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
</script>
@endsection
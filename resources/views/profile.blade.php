@extends('layouts.app')

@section('title', 'Profile')
@section('content')
<div class="text-center">
    <img src="https://api.dicebear.com/9.x/dylan/svg?seed={{ auth()->user()->name }}" alt="Profile" class="rounded-pill w-100 border border-white" style="max-width: 100px">
    <h4 class="mt-3 text-white fw-bold">{{ auth()->user()->name }}</h4>
    <p class="text-white">{{ auth()->user()->email }}</p>
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
    <form method="POST" action="">
        @csrf
        @method('PUT')
        {{-- name --}}
        <div class="mb-3">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" placeholder="Name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" required autocomplete="email" placeholder="Email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- password --}}
        <div class="mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="New Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- password confirmation --}}
        <div class="mb-3">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
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
                <form method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <input id="current-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
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
</script>
@endsection
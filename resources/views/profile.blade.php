@extends('layouts.app')

@section('title', 'Profile')
@section('content')
<div class="text-center">
    <img src="https://api.dicebear.com/9.x/thumbs/svg?seed={{ auth()->user()->name }}" alt="Profile" class="rounded-pill w-100 border border-white" style="max-width: 100px">
    <h4 class="mt-3 text-white fw-bold">{{ auth()->user()->name }}</h4>
    <p class="text-white">{{ auth()->user()->email }}</p>
</div>

{{-- update email password --}}
<div class="mt-3">
    <h5 class="fw-bold text-white">Update Email & Password</h5>
    <form method="POST" action="">
        @csrf
        @method('PUT')
        {{-- email --}}
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
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- password confirmation --}}
        <div class="mb-3">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn btn-light d-block w-100 fw-bold text-primary mb-3">
            {{ __('Update') }}
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger d-block w-100 fw-bold">
            {{ __('Logout') }}
        </button>
    </form>
</div>
@endsection

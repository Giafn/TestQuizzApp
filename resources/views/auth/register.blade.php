@extends('layouts.guest')

@section('content')
<div class="vh-100 d-flex align-items-center flex-column justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mt-3 mb-5">Register to <span class="text-primary fw-bold">Quizz<span class="text-warning">App</span></span></h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        {{-- name --}}
                        <div class="mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
    
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        </div>

                        <button type="submit" class="btn btn-primary d-block w-100">
                            {{ __('Register') }}
                        </button>
                        <div class="text-center text-secondary">
                            or
                        </div>
                        <a href="{{ route('login') }}" class="btn d-block w-100">
                            {{ __('Login') }}
                        </a>
                    </form>
                </div>
            </div>
</div>
@endsection


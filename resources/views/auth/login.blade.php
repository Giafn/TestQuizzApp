@extends('layouts.guest')

@section('content')
<div class="vh-100 d-flex align-items-center flex-column justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mt-3 mb-5">Login to <span class="text-primary fw-bold">Quizz<span></h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="*******************">
    
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary d-block w-100">
                            {{ __('Login') }}
                        </button>
                        <div class="text-center text-secondary">
                            or
                        </div>
                        <a href="{{ route('register') }}" class="btn w-100">
                            {{ __('Register') }}
                        </a>
                    </form>
                </div>
            </div>
</div>
@endsection

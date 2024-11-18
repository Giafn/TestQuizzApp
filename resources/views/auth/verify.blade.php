@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4>
                {{ __('Verify Your Email Address') }}
            </h4>
            @if (session('resent'))
                <div class="alert alert-primary" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email (' . auth()->user()->email . ') for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
            <p class="mt-1">
                {{ __('If you entered the wrong email, please update your email at') }} <a href="/profile" class="text-primary">{{ __('Profile') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection

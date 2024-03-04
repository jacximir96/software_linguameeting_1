@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-corporate-color-light text-corporate-dark-color fw-bold">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="card-body py-4">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <div class="row">

                        <div class="col-12">

                            <p class="text-corporate-dark-color fw-bold">Thanks for the register. Please check your email to activate your account.</p>

                            <p class="colorBase1 mt-3">
                                See the spam folder if you don't find the email.
                            </p>

                        </div>
                    </div>

                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline small text-corporate-dark-color fw-bold" style="font-size: 0.9rem">
                            {{ __('click here to request another') }}
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app_forgot')

@section('content')

    <div class="row">
        <div class="col-12 text-left">
            <p class="colorBase1 font-weight-bold">If you forgot your password, please enter your e-mail and we send you a new password.</p>
        </div>

    </div>



    <div class="row">

        @if (session('status'))
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <p>{{ session('status') }}</p>

                    <p>
                        If there is an account associated with <span class="text-decoration-underline">{{session('emailRecovery')}}</span>, <span class="font-weight-bold">you will receive an email with a link to create a new password</span> .
                    </p>
                    <p>
                        If you don not see this email in your inbox within 15 minutes, look for it in your junk mail folder. If you find it there, please mark the email as Not Junk and add @linguameeting.com to your address book

                    </p>

                </div>
            </div>
        @endif

        <div class="col-12 mt-2">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="row">

                    <label for="email" class="col-md-3 col-form-label text-md-end">
                        {{ __('Email Address') }}
                    </label>

                    <div class="col-md-9">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 ">
                        <button type="submit" class="btn backgroundColorBase2 text-white p-1 px-2">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>

                <div class="row mb-3">

                </div>
            </form>

        </div>

        <div class="col-12 mt-4">



        </div>


    </div>


@endsection

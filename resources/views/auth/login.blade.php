@extends('layouts.app_login')

@section('content')

    <form method="POST" action="{{ route('login') }}" class="form-signin">
        @csrf
        <span id="reauth-email" class="reauth-email"></span>
        <div>

            <input id="email" type="email" class="inputTextLogin @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
            
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="margin-top20">

            <input id="password" type="password" class="inputTextLogin @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="text_center">
            <button type="submit" class="btnBasicRed textBtnLearnMore margin-top40 w600">
                {{ __('LogIn') }}
            </button>
        </div>
    </form>
@endsection

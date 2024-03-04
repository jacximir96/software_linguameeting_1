@extends('web.layout.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" style="width: 70%">
                <div class="card-headerq color2 font-weight-bold ">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                @include('common.web.password')

                                <div class="d-flex justify-content-between">
                                    <a href="{{route('get.public.password.generate')}}" class="fst-italic small" id="generate_password">Generate</a>

                                    <a href="#" class="text-primary show-hide-password small" id="basic-addon1">
                                        Hide
                                    </a>
                                </div>

                            </div>


                        </div>

                        <div class="row mb-0 mt-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn backgroundColorBase2 text-white">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});


        jQuery(document).on('click', '.show-hide-password', function (event) {

            event.preventDefault();

            showOrHidePasswordContent(jQuery(this), 'password')
            showOrHidePasswordContent(jQuery(this), 'password_confirmation')
        });

        function showOrHidePasswordContent (element, passwordFieldId){

            var fieldPassword = jQuery('#'+passwordFieldId);

            if (fieldPassword.attr('type') == "password") {

                fieldPassword.removeAttr("type");
                fieldPassword.attr("type","text");

                element.html('Hide')

            } else {

                fieldPassword.removeAttr("type");
                fieldPassword.attr('type','password');

                element.html('Show')
            }
        }
    });
</script>

@endsection

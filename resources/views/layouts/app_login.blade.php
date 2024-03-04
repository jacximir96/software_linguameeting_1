<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')

<main  id="container-principal">

    <section id="section1_login" class="margin-top60">

        <div class="paddingSection section1_login">

            <div class="row">
                <div class="col-md-6">

                </div>


                <div class="col-md-6 zIndex100" >

                    <div class="fontRecoleta text-62 colorBase1 text_center ">
                        Welcome Back!
                    </div>


                    <div class="margin-top60 text_center zIndex100">
                        @yield('content')

                    </div>


                    <div class="margin-top40">
                        <a href="{{ route('password.request') }}" class="colorBase1 borderBottomText">
                            <strong>Forgot the password?</strong>
                        </a>
                    </div>

                    <div class="colorBase1 margin-top10">
                        Don't have an account?
                            <a href="{{route('register')}}" class="colorBase1">
                                <span class="borderBottomText"><strong>Register here</strong></span>
                            </a>
                    </div>


                    <div>

                    </div>

                </div>

            </div>

            <div class="divMichelleLogin">

                <div>
                    <img class="imgMichelleLogin" src="{{asset('assets/img/web/michelle-login.png')}}" alt="Coach Michelle Login">
                </div>

            </div>

        </div>


    </section>

    @include('layouts.difference_info')



</main>


<div id="modal_forgot" class="hidden-print modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Forgot your password?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>If you forgot your password, please enter your e-mail and we send you a new password.</p>
            </div>
            <div class="form-group">
                <input type="email" name="email-forgot" id="email-forgot" tabindex="1" class="form-control input-lg" placeholder="Email Address" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="doForgotEmail()" ng-disabled="buttonsDisabled">Send</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!--<div id="layoutAuthentication" >
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header bg-text-corporate-color text-white">
                                <h5 class="text-center font-weight-light my-2">Login LinguaMeeting</h5>
                            </div>
                            <div class="card-body">
                                @yield('content')

                            </div>
                            <div class="card-footer text-center py-3 small">
                                @if (Route::has('password.request'))
                                    <p class="mb-0">
                                        <a class="text-corporate-color" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </p>
                                @endif

                                Don't have an account?
                                <span class="small"><a href="{{route('register')}}" class="text-corporate-color">Register here</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-2 bg-text-corporate-color mt-auto">
            @include('common.footer')
        </footer>
    </div>
</div>-->

@include('common.web.footer')

</body>
</html>

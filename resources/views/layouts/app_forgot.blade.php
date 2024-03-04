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

                    <div class="fontRecoleta text-54 colorBase1 text_center ">
                        Forgot your password?
                    </div>

                    <div class="margin-top60 text_center zIndex100">
                        @yield('content')
                    </div>

                    <div class="colorBase1 margin-top10 mt-5">
                        Don't have an account?
                            <a href="{{route('register')}}" class="colorBase1">
                                <span class="borderBottomText"><strong>Register here</strong></span>
                            </a>
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

@include('common.web.footer')

</body>
</html>

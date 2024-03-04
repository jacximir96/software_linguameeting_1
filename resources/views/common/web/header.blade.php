<header class="" id="headerWeb">

    <nav class="navbar navbar-expand-lg backgroundColorBase3 fixed-top" id="navbarWeb">


        <div class="navbar-toggler widthAll" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">

            <div class="navbar-toggler-icon my-toggler float_left">
                <div class="colorBase1 borderBottomText padding-bottom5 w600">Menu</div>
            </div>
            <div class="KvZmB float_right">
                <a href="{{route('landing')}}"><img src="{{asset('assets/img/NewLogoLinguaMeeting.png')}}"></a>
            </div>

	</div>


        <div class="widthNavBar collapse navbar-collapse clear_both" id="navbarNavDropdown">

            <div class="hWayde">
                <ul class="varBarOptions">

                    <li class="iniev KvZmB" id="imgNotShowMobile">
                        <a href="{{route('landing')}}"><img src="{{asset('assets/img/NewLogoLinguaMeeting.png')}}"></a>
                    </li>

                    <li class="iniev KvZmB">
                        <a class="nav-link colorBase1 w500 btnMenuWeb" href="{{route('landing')}}">Home</a>
                    </li>


                    <li class="iniev KvZmB cursor_pointer nav-item dropdown">
                        <a class="nav-link colorBase1 w500 btnMenuWeb" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            How it works
                        </a>

                        <div class="dropdown-menu fontRecoleta colorBase1" aria-labelledby="navbarDropdownMenuLink">
                            <a class="nav-link w500 colorBase1" href="{{url('how-it-works/instructors')}}">For Instructors</a>
                            <a class="nav-link w500 colorBase1" href="{{url('how-it-works/students')}}">For Students</a>
                        </div>
                    </li>

                    <li class="iniev KvZmB">
                        <a class="nav-link colorBase1 w500 btnMenuWeb" href="{{route('pricing')}}">Pricing</a>
                    </li>

                    <li class="iniev KvZmB">
                        <a class="nav-link colorBase1 w500 btnMenuWeb" href="{{route('experiences')}}">Experiences</a>
                    </li>

                    <li class="iniev KvZmB cursor_pointer nav-item dropdown">
                        <a class="nav-link colorBase1 w500 btnMenuWeb" href="#" id="navbarDropdownMenuLink2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            About
                        </a>

                        <div class="dropdown-menu fontRecoleta colorBase1" aria-labelledby="navbarDropdownMenuLink2">
                            <a class="nav-link w500 colorBase1" href="{{route('about')}}">Team</a>
                            <a class="nav-link w500 colorBase1" href="{{route('coaches')}}">Coaches</a>
                        </div>
                    </li>


                    <li class="iniev KvZmB">
                        <a class="nav-link colorBase1 w500 btnMenuWeb" href="{{route('support')}}">Support</a>
                    </li>

                    @auth
                        <li class="iniev KvZmB margin-right10">
                            <a class="colorBase4" href="{{route('home')}}">
                                <div class="padding10 text_center ">
                                    <strong>Dashboard</strong>
                                </div>

                            </a>
                        </li>
                    @endauth

                    @guest
                    <li class="iniev KvZmB margin-right10">
                        <a class="colorBase4" href="{{route('login')}}">
                            <div class="padding10 text_center ">
                                <strong>Login</strong>
                            </div>

                        </a>
                    </li>

                    <li class="iniev KvZmB">

                        <a class="colorBase1" href="{{route('register')}}">
                            <div class="btnBasicRed w600">
                                Register
                            </div>
                        </a>

                    </li>
                    @endguest

                </ul>

            </div>


        </div>

    </nav>


</header>

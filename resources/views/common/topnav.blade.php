
<a class="navbar-brand bg-text-corporate-color ps-3 text-white" href="{{route('home')}}">LinguaMeeting</a>

<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 bg-text-corporate-color text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

</form>
<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li>
                @if (user()->isCoach())
                    <a class="dropdown-item" href="{{route('get.coach.profile.edit')}}">My Profile</a>
                @elseif(user()->isStudent())
                    <a class="dropdown-item" href="{{route('get.student.profile.edit')}}">My Profile</a>
                @else
                    <a class="dropdown-item" href="{{route('get.user.profile.edit')}}">My Profile</a>
                @endif
            </li>
            
            @if (user()->isInstructor())
            <li>
                <a class="dropdown-item" href="{{route('get.instructor.alerts.edit')}}">Notifications & Alerts</a>
            </li>
            <li>
                <a class="dropdown-item" href="{{route('get.instructor.admin.index')}}">Account Admin</a>
            </li>
            @endif
            <li>
                <hr class="dropdown-divider"/>
            </li>

            @impersonating()
                <li><a class="dropdown-item text-danger" href="{{route('get.impersonate.leave')}}">Go out simulation</a></li>
                <li>
                    <hr class="dropdown-divider"/>
                </li>

            @endImpersonating

            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
</ul>

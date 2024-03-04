<div class="nav">
    <div class="sb-sidenav-menu-heading" style="font-size:16px; text-transform: none;">Hello {{user()->name}}</div>
    <a class="nav-link" href="{{route('get.coach.dashboard')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>

    <a class="nav-link" href="{{route('get.coach.schedule.show')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
        Availability
    </a>

    <a class="nav-link" href="{{route('get.coach.calendar.show')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>
        Calendar
    </a>

    <a class="nav-link" href="{{route('get.coach.class.today.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-headphones"></i></div>
        Go to Class
    </a>

    <a class="nav-link" href="{{route('get.coach.course.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
        Courses
    </a>

    <a class="nav-link" href="{{route('get.coach.experience.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-photo-video"></i></div>
        Experiences
    </a>

    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#universitiesLayouts" aria-expanded="false" aria-controls="universitiesLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
        Feedback
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="universitiesLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('get.coach.feedback.instructor.index')}}">From Instructor</a>
            <a class="nav-link" href="{{route('get.coach.feedback.manager.index')}}">From Linguameeting</a>
            <a class="nav-link" href="{{route('get.coach.feedback.student.index')}}">From Student</a>
        </nav>
    </div>

    <a class="nav-link" href="{{route('get.coach.help.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
        Help
    </a>

    <a class="nav-link" href="{{route('get.coach.messaging.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
        Messaging
    </a>

    <a class="nav-link" href="{{route('get.notification.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
        Notifications
    </a>

    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#billingSidebar" aria-expanded="false" aria-controls="billingSidebar">
        <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div>
        Billing
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="billingSidebar" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('get.coach.billing.profile.edit')}}">Profile</a>
            <a class="nav-link" href="{{route('get.coach.billing.invoice.index')}}">Invoices</a>
        </nav>
    </div>

</div>

<div class="nav">
    <div class="sb-sidenav-menu-heading" style="font-size:16px; text-transform: none;">Hello {{user()->name}}</div>
    <a class="nav-link" href="{{route('get.instructor.dashboard')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>

     <a class="nav-link" href="{{route('get.instructor.coaching_form.zero_step')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
        Create Course
    </a>

    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#universitiesLayouts" aria-expanded="false" aria-controls="universitiesLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
        Courses
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="universitiesLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('get.instructor.course.index')}}">Active Courses</a>
            <a class="nav-link" href="{{route('get.instructor.course.gradebook.index')}}">Gradebook</a>
            <a class="nav-link" href="{{route('get.instructor.experiences.dashboard')}}">Experiences</a>
            <a class="nav-link" href="{{route('get.instructor.course.schedule.index')}}">Schedule</a>
            <a class="nav-link" href="{{route('get.instructor.course.coaches.index')}}">Coach List</a>
            <a class="nav-link" href="{{route('get.instructor.course.past_course.index')}}">Past Courses</a>
        </nav>
    </div>

    <a class="nav-link" href="{{route('get.instructor.resources.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
        Asignments
    </a>

    <a class="nav-link" href="{{route('get.instructor.canvas.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
        Canvas
    </a>

    <a class="nav-link" href="{{route('get.instructor.help.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-question-circle"></i></div>
        Help
    </a>

    <a class="nav-link" href="{{route('get.instructor.messaging.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
        Messaging
    </a>

    <a class="nav-link" href="{{route('get.notification.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
        Notifications
    </a>


</div>

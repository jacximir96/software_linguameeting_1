<div class="nav">
    <div class="sb-sidenav-menu-heading" style="font-size:16px; text-transform: none;">Hello {{user()->name}}</div>
    <a class="nav-link" href="{{route('get.student.dashboard')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>

    <a class="nav-link" href="{{route('get.student.calendar.show')}}" title="Show Calendar">
        <div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>
        Calendar
    </a>

    <a class="nav-link" href="{{route('get.student.enrollment.past.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-file-archive"></i></div>
        Past Courses
    </a>

    <a class="nav-link" href="{{route('get.student.support.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
        Support & FAQ
    </a>

    <a class="nav-link" href="{{route('get.notification.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
        Notifications
    </a>

    <a class="nav-link" href="{{route('get.student.payment.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div>
        Payments
    </a>


</div>

<?php use App\Src\Shared\Presenter\SidebarMenu; ?>
<div class="nav">
    <div class="sb-sidenav-menu-heading">Core</div>
    <a class="nav-link" href="{{route('get.admin.dashboard.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>
    <div class="sb-sidenav-menu-heading">Actions</div>

    <a class="nav-link" href="{{route('get.admin.course.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-headphones"></i></div>
        Courses
    </a>

    <a class="nav-link {{SidebarMenu::isOpenUniversity() ? 'fw-bold' : 'collapsed'}}"
       href="#"
       data-bs-toggle="{{SidebarMenu::isOpenUniversity() ? '' : 'collapse'}}"
       data-bs-target="#universitiesLayouts"
       aria-expanded="{{SidebarMenu::isOpenUniversity() ? 'true' : 'false'}}"
       aria-controls="universitiesLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-university"></i></div>
        University
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="{{SidebarMenu::isOpenUniversity() ? '' : 'collapse'}}" id="universitiesLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link {{SidebarMenu::isOpenUniversityOption() ? 'text-corporate-color' : ''}}" href="{{route('get.admin.university.index')}}">
                Universities
            </a>
            <a class="nav-link {{SidebarMenu::isOpenUniversityBookstore() ? 'text-corporate-color' : ''}}" href="{{route('get.admin.register_code.bookstore_request.index')}}">
                Registration Codes
            </a>
        </nav>
    </div>

    <a class="nav-link {{SidebarMenu::isOpenInstructors() ? 'fw-bold__' : 'collapsed__'}}" href="{{route('get.admin.instructor.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
        Instructors
    </a>


    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#coachesLayouts" aria-expanded="false" aria-controls="coachesLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        Coaches
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="coachesLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('get.admin.coach.index')}}">Coaches</a>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#billingCoachOptions" aria-expanded="false" aria-controls="billingCoachOptions">
                Billing
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="billingCoachOptions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('get.admin.coach.billing.for_all.index')}}">Billing</a>
                    <a class="nav-link" href="{{route('get.admin.coach.billing.salary.coordinators.index')}}">Coordinators</a>
                </nav>
            </div>
            <a class="nav-link" href="{{route('get.admin.coach.status.index')}}">Active/Inactive</a>
            <a class="nav-link" href="{{route('get.admin.coach.ranking.index')}}">Ranking</a>
            <a class="nav-link" href="{{route('get.admin.coach.review.index')}}">Reviews</a>
            <a class="nav-link" href="{{route('get.admin.coach.zoom.meeting.index')}}">Zoom Meetings</a>
        </nav>
    </div>

    <a class="nav-link" href="{{route('get.admin.student.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
        Students
    </a>

    @if (user()->hasStudentRol())
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#studentsRol" aria-expanded="false" aria-controls="studentsRol">
            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
            Students Role
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="studentsRol" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                @if(user()->enrollmentActive())
                    <a class="nav-link" href="{{route('get.student.enrollment.show', user()->enrollmentActive()->id )}}">My Course</a>
                @endif
            </nav>
        </div>
    @endif

    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#messaging" aria-expanded="false" aria-controls="configLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
        Messaging
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="messaging" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('get.admin.messaging.inbox.index')}}">Inbox</a>
            <a class="nav-link" href="{{route('get.admin.messaging.sent.index')}}">Sent</a>
        </nav>
    </div>

    <a class="nav-link" href="{{route('get.notification.index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
        Notifications
    </a>

    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#configOptions" aria-expanded="false" aria-controls="configOptions">
        <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
        Config
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="configOptions" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
            <a class="nav-link" href="{{route('get.admin.config.accommodation_type.index')}}">Accommodation Type</a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#billingConfOptions" aria-expanded="false" aria-controls="billingConfOptions">
                Billing
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="billingConfOptions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('get.admin.coach.billing.config.invoice.info_paid.edit')}}">Info Invoice</a>
                    <a class="nav-link" href="{{route('get.admin.coach.billing.config.discount.options.index')}}">Discount Types</a>
                    <a class="nav-link" href="{{route('get.admin.coach.billing.config.incentive.options.index')}}">Incentive Types</a>
                    <a class="nav-link" href="{{route('get.admin.payment.index')}}">Payments</a>
                </nav>
            </div>
            <a class="nav-link" href="{{route('get.admin.config.jira.chat.edit')}}">Chat & Jira</a>

            <a class="nav-link" href="{{route('get.admin.config.conversation_package.index')}}">Conversation Package</a>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#experienceOptions" aria-expanded="false" aria-controls="experienceOptions">
                Experiences
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="experienceOptions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('get.admin.experience.index')}}">Experiences</a>
                    <a class="nav-link" href="{{route('get.admin.config.experience_level.index')}}">Levels</a>
                </nav>
            </div>



            <a class="nav-link" href="{{route('get.admin.config.conversation_guide.index')}}">Guides</a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#helpConfOptions" aria-expanded="false" aria-controls="helpConfOptions">
                Help
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="helpConfOptions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('get.admin.coach.help.index')}}">Coach Help</a>
                    <a class="nav-link" href="{{route('get.admin.instructor.help.index')}}">Instructor Help</a>
                    <a class="nav-link" href="{{route('get.admin.student.help.index')}}">Student Help</a>
                </nav>
            </div>

            <a class="nav-link" href="{{route('get.admin.survey.index')}}">Survey</a>
            <a class="nav-link" href="{{route('get.admin.config.user.edit')}}">User</a>
        </nav>
    </div>
</div>

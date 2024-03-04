@if ($course->isFlex())
    @include('student.enrollment.session.api.header_info_session_flex', [
         'course' => $course,
         'sessionOrder' => $sessionOrder,
         'isCreateBook' => $isCreateBook,
     ])
@else
    @include('student.enrollment.session.api.header_info_session_week', [
        'coachingWeek' => $coachingWeek,
        'isCreateBook' => $isCreateBook,
    ])
@endif


@if ($course->conversationPackage->sessionType->isSmallGroup() AND $viewData->schedule()->hoursTimeSorted()->count())
    @include('student.enrollment.session.api.warning_text')


    @if (isset($paginatorPeriod))
        @if ($course->isFlex())
            @include('student.enrollment.session.api.paginator_flex')
        @else
            @include('student.enrollment.session.api.paginator_weeks')
        @endif
    @endif


    <div class="row">
        <div class="col-12 overflow-auto element-with-scroll position-relative" style="height: auto;">
            @include('student.enrollment.session.api.sessions_table')
        </div>
        <div class="col-12 text-end">
            <a href="#" class="text-corporate-dark-color fw-bold small text-decoration-underline float-end" id="show-all-sessions-link">Remove Filters</a>
        </div>
    </div>


    @include('student.enrollment.session.api.sessions_coaches')


    @include('admin.course.schedule.javascript')

@else

    @if ($course->conversationPackage->sessionType->isSmallGroup())
        <div class="row my-4 gx-0">
            <div class="col-12 ps-2 ">
                <span class="text-corporate-danger">Actualmente, no existen sesiones de tu curso para poder unirte. Utiliza el buscador de abajo para buscar sesiones.</span>
            </div>
        </div>
    @endif

@endif

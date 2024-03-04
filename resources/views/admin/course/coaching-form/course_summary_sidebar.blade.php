<h5 class="fw-bold">Course Summary</h5>

<hr>

@include('admin.course.coaching-form.sidebar-summary.academic_dates')

@if ($courseSummary->isCourse())
    @include('admin.course.coaching-form.sidebar-summary.course_information')
@endif

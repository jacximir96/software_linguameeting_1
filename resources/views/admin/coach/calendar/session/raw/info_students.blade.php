<b>Students</b>
@foreach ($viewData->sessionAssignment()->enrollmentsSession() as $enrollmentSession)
    @include('admin.coach.calendar.session.raw.enrollment_session_info', ['enrollmentSession' => $enrollmentSession])
@endforeach
<b>Assignments</b>
@if ($viewData->sessionAssignment()->hasAssignment())
    @include('admin.coach.calendar.session.raw.info_assignment', ['assignment' => $viewData->sessionAssignment()->assignment()])
@else
    Assignments not exists for this session.
@endif


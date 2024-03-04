<b> Makeup Students</b>
@foreach ($viewData->makeupSessionsAssignments() as $makeupSessionAssignment)

@forelse ($makeupSessionAssignment->enrollmentsSession() as $enrollmentSession)
    @include('admin.coach.calendar.session.raw.enrollment_session_info', ['enrollmentSession' => $enrollmentSession])
@endforelse

@if ($makeupSessionAssignment->hasAssignment())
    @include('admin.coach.calendar.session.raw.info_assignment', ['assignment' => $makeupSessionAssignment->assignment()])
@else
    Assignments not exists for this makeup session.
@endif

@endforeach


@if ($itemBag->hasSessionOrder($flexSession->sessionOrderObject()))

    @php $enrollmentSession = $itemBag->getSessionByOrder($flexSession->sessionOrderObject()) @endphp

    @include('student.enrollment.session.booked_flex', [
        'enrollmentSession' => $enrollmentSession,
        'session' => $enrollmentSession->session
    ])
@else
    @include('student.enrollment.session.no_booked_flex', [
        'enrollment' => $viewData->enrollment(),
        'flexSession' => $flexSession
    ])
@endif

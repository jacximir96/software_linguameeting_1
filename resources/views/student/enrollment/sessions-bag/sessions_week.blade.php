@if ($itemBag->hasSessionOrder($coachingWeek->sessionOrderObject()))

    @php $enrollmentSession = $itemBag->getSessionByOrder($coachingWeek->sessionOrderObject()) @endphp

    @include('student.enrollment.session.booked', [
        'enrollmentSession' => $enrollmentSession,
        'session' => $enrollmentSession->session
    ])
@else
    @include('student.enrollment.session.no_booked', [
        'enrollment' => $viewData->enrollment(),
        'sessionWeek' => $coachingWeek
    ])
@endif

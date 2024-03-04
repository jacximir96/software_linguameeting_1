Student: {{$enrollmentSession->enrollment->user->writeFullName()}}
@if ($enrollmentSession->isMakeupWeek())
    (Additional Make-Up Period)
@endif

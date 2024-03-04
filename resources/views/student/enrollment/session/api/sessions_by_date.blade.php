<?php /* Slots de cada celda del calendario */ ?>
@foreach ($sessionsByHour->sessionsOnDay($date->dayOfWeek) as $session)

    @if ( ! $session->isDay($date))
        @continue
    @endif

    <a href="{{route('get.student.session.show', [$session->session(), $enrollment->hashId(), $sessionOrder->get()])}}"
       class="w-50 d-inline-block open-modal mb-1 label badge small text-white {{$session->session()->occupation()->isFull() ? 'bg-success' : 'bg-primary'}} session-coach"
       data-modal-reload="yes"
       data-reload-type="parent"
       data-modal-size="modal-lg"
       data-modal-height="h-90"
       data-modal-title="Session Assignment"
       title='Session {{toMonthDayAndYearExtendShort($session->moment(), $userTimezone->name)}}'
       data-coach-id="{{$session->coach()->hashId()}}"
     >
        {{$session->session()->occupation()->currentRegistered()}}  / {{$session->session()->occupation()->totalAllowed()}}
    </a>

@endforeach

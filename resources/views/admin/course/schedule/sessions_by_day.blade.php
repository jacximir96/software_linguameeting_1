@foreach ($sessionsByHour->sessionsOnDay($date->dayOfWeek) as $session)

    @if ( ! $session->isDay($date))
        @continue
    @endif

    <a href="#"
       class="w-50 d-inline-block mb-1 label badge small text-white {{$session->occupation()->isFull() ? 'bg-success' : 'bg-primary'}} session-coach"
       data-coach-id="{{$session->coach()->id}}"
       data-bs-toggle="modal"
       data-bs-target="#modal-info-session-{{$session->key()}}">
       {{$session->occupation()->currentRegistered()}}  / {{$session->occupation()->totalAllowed()}}
    </a>

    @include('common.modal_info', [
        'modalId' => 'modal-info-session-'.$session->key(),
        'modalTitle' => 'Session '.$session->moment()->format('M d Y').' at '.$session->moment()->format('H:i:s'),
        'size' => 'modal-lg',
        'path' => 'admin.course.schedule.session',
        'session' => $session,
    ])

@endforeach

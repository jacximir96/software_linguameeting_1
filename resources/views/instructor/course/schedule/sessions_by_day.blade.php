
    <a href="#"
       class="w-50 d-inline-block mb-1 label badge small text-white bg-primary session-coach"
       data-coach-id=""
       data-bs-toggle="modal"
       data-bs-target="#modal-info-session-{{$session['id']}}" style="height: 40px; width: 120px; display: flex; justify-content: center; align-items: center; line-height: 30px;">
       Session - {{$session['session']}}
       {{-- {{$session['name_course']}} --}}
       {{-- {{$session['id']}} --}}
    </a>

    @include('common.modal_info', [
        'modalId' => 'modal-info-session-'.$session['id'] ,
        'modalTitle' => 'Session at '.$session['start_time'].'pm',
        'size' => 'modal-lg',
        'path' => 'instructor.course.schedule.session',
        'session' => $session,
    ])



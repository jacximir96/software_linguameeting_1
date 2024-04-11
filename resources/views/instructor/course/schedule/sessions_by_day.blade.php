<a href="#"
   class="d-inline-block mb-1 label badge small text-white"
   data-coach-id=""
   data-bs-toggle="modal"
   data-bs-target="#modal-info-session-{{$session['idSession']}}" style="display: inline-block;">
   <div style="background-color: green; padding: 8px; border-radius: 5px;">
       Session - {{$session['session']}}
   </div>
</a>


    @include('common.modal_info', [
        'modalId' => 'modal-info-session-'.$session['idSession'] ,
        'modalTitle' => 'Session at '.$session['start_time'].'pm',
        'size' => 'modal-lg',
        'path' => 'instructor.course.schedule.session',
        'session' => $session,
    ])



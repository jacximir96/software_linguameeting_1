<div class="row small">

    <div class="col-xl-4 text-center">
        @if ($coach->profileImage)
            <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid {{isset($imageWidth) ? 'imageWidth' : ''}}" alt="Coach Photo">
        @else
            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid  {{isset($imageWidth) ? 'imageWidth' : ''}}" alt="Coach Photo">
        @endif

        <a href="#"
           class="d-block mt-1 text-corporate-dark-color small"
           data-bs-toggle="modal"
           data-bs-target="#modal-coach-{{$coach->hashId()}}">
            View
        </a>

    </div>
    <div class="col-xl-8">
        <span class="d-block fw-bold">{{$coach->writeFullNameAndLastname()}}</span>
        <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
             title="Flag of {{$coach->country->name}}"
             class="img-thumbnail flag-icon-25 me-20"/>
        <span class="d">{{$coach->country->name}}</span>

        @include('common.modal_info', [
            'modalId' => 'modal-coach-'.$coach->hashId(),
            'modalTitle' => 'Coach '.$coach->writeFullNameAndLastname(),
            'size' => 'modal-md',
            'path' => 'student.enrollment.session.modal_info_coach',
            'coach' => $coach,
            'reviewsStats' => $reviewsStats,
        ])

        @if ($reviewsStats)
            <div class="small">
                @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
            </div>
        @endif
    </div>

    @if (isset($showFilterSessions))
        <div class="row mt-0">
            <div class="col-12 text-center">

                <a href="#"
                   class="d-block text-corporate-dark-color fw-bold small text-decoration-underline select-session-coach"
                   data-coach-id="{{$coach->hashId()}}">Filter Sessions</a>
            </div>
        </div>

    @endif
</div>



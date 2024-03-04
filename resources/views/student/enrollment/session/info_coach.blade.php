<div class="row">

    <div class="col-xl-4 text-center">
        @if ($session->coach->profileImage)
            <img src="{{asset($session->coach->profileImage->url()->get())}}" class="img-fluid" alt="Coach Photo">
        @else
            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid" alt="Coach Photo">
        @endif

        <a href="#"
           class="d-block mt-1 text-corporate-dark-color small"
           data-bs-toggle="modal"
           data-bs-target="#modal-coach-{{$session->coach->hashId()}}">
            View
        </a>
    </div>
    <div class="col-xl-8">
        <span class="d-block fw-bold">{{$session->coach->writeFullNameAndLastname()}}</span>
        <span class="d-block text-muted small">{{$session->coach->country->name}}</span>

        @include('common.modal_info', [
            'modalId' => 'modal-coach-'.$session->coach->hashId(),
            'modalTitle' => 'Coach '.$session->coach->writeFullNameAndLastname(),
            'size' => 'modal-md',
            'path' => 'student.enrollment.session.modal_info_coach',
            'coach' => $session->coach,
            'reviewsStats' => $viewData->reviewsStatsCollection()->getByCoach($session->coach)->reviewsStats(),
        ])

        @php $reviewsStats = $viewData->reviewsStatsCollection()->getByCoach($session->coach)->reviewsStats() @endphp

        @if ($reviewsStats)
            <div class="small">
                @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
            </div>

        @endif

    </div>
</div>

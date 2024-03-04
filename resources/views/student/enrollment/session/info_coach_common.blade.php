<div class="row">

    <div class="col-xl-4 text-center">
        @if ($coach->profileImage)
            <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid w-50" alt="Coach Photo">
        @else
            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid w-50" alt="Coach Photo">
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
        <span class="d-block text-muted small">{{$coach->country->name}}</span>

        @include('common.modal_info', [
            'modalId' => 'modal-coach-'.$coach->hashId(),
            'modalTitle' => 'Coach '.$coach->writeFullNameAndLastname(),
            'size' => 'modal-md',
            'path' => 'student.enrollment.session.modal_info_coach',
            'coach' => $coach,
            'reviewsStats' => $reviewsStatsCollection->getByCoach($coach)->reviewsStats(),
        ])

        @php $reviewsStats = $reviewsStatsCollection->getByCoach($coach)->reviewsStats() @endphp

        @if ($reviewsStats)
            <div class="small">
                @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
            </div>

        @endif

    </div>
</div>

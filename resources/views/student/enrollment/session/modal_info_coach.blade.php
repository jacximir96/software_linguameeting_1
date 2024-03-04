<div class="row">

    <div class="col-3">
        @if ($coach->profileImage)
            <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid" alt="Coach Photo">
        @else
            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid" alt="Coach Photo">
        @endif
    </div>

    <div class="col-9">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <span class="d-block fw-bold">{{$coach->writeFullNameAndLastname()}}</span>

                @if ($reviewsStats)
                    <div class="small">
                        @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                        <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
                    </div>

                @endif
            </div>
            <div class="col-12 mt-2 d-inline-block">
                <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
                     title="Flag of {{$coach->country->name}}"
                     class="img-thumbnail flag-icon-25 me-20"/>
                <span class="d">{{$coach->country->name}}</span>
            </div>
            <div class="col-12 mt-3">

                @if ($coach->coachInfo->hasUrlVideo())
                    <div class="">
                        <a href="{{$coach->coachInfo->urlVideo()->get()}}"
                           target="_blank"
                           class="border border-2 p-1 border-color-corporate-dark text-corporate-dark-color"
                           title="See coach video">
                            <i class="fa fa-play mx-2"></i> See coach video
                        </a>
                    </div>
                @endif
            </div>


        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12" style="white-space: normal">
        {!! $coach->coachInfo->description !!}
    </div>
</div>

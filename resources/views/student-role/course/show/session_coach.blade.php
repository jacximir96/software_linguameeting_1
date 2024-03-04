<div class="">
    <span class="d-block fw-bold">
        {{$coach->writeFullName()}}
    </span>
    <div>
        @php $reviewsStats = $coach->reviewStats() @endphp
        @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
        <span class="small fst-italic ms-2">{{$reviewsStats->total()}} reviews</span>
    </div>
</div>

<div>
    <p class="mb-0 mt-2">
        <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
             title="Flag of {{$coach->country->name}}"
             class="img-thumbnail flag-icon-25 me-20" />

        <span class="d-inline-block">
            {{$coach->country->name}}
        </span>
    </p>
</div>

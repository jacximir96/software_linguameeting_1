<div class="row">
    <div class="col-3">
        <i class="fa fa-user fa-3x"></i>
    </div>
    <div class="col-9">
        <div>
            <a href="{{route('get.admin.coach.show', $coach->id)}}" class="mr-2" target="_blank" title="Show coach">
                {{$coach->writeFullName()}}
            </a>
        </div>

        <div class="">
            <p class="mb-0">
                <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
                     title="Flag of {{$coach->country->name}}"
                     class="img-thumbnail flag-icon-25 me-20" />
                {{$coach->country->name}}
            </p>
            <p class="mb-0">
                <i class="fa fa-star small rating-color"></i>
                <i class="fa fa-star small rating-color"></i>
                <i class="fa fa-star small rating-color"></i>
                <i class="fa fa-star small rating-color"></i>
                <i class="fa fa-star small "></i>
            </p>
        </div>
    </div>
    <div class="col-12">
        <p class="small text-muted mb-0">
            @if ($coach->hobby->count())
                <span class="text-corporate-dark-color fw-bold">Le gusta</span> {{$coach->hobby->implode(function ($hobby){return $hobby->description;},', ')}}
            @else
                <span class="subtitle-color">Without Hobbies</span>
            @endif
        </p>
    </div>
    <div class="col-12 text-center mt-2">
        <a href="#"
           class="text-corporate-dark-color fw-bold small text-decoration-underline select-session-coach"
           data-coach-id="{{$coach->id}}">Select Sessions</a>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <span class="text-corporate-dark-color fw-bold">
            @if ($enrollment->course()->serviceType->isExperiences())
                Included in your package
            @else
                Optional
            @endif

        </span>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <img src="{{asset('assets/img/logo_experiences.png')}}" class="img-fluid w-40" />
    </div>

    @if ( ! $enrollment->course()->serviceType->isExperiences())
        <div class="position-absolute top-0 start-0 text-end">
            <img src="{{asset('assets/img/experience_dashboard_rotate.png')}}" class="img-fluid badge-experience" />
        </div>
    @endif
</div>

<div class="row mb-5">
    <div class="col-12">
        <span class="h5 text-muted d-block mb-0">Term</span>
        <span class="d-inline-block small-font-size-rem-1-1">
            {{$enrollment->course()->semester->name}} {{$enrollment->course()->year}}
        </span>
    </div>
</div>

<div class="row mt-4  position-absolute w-100" style="bottom: 20px">
    <div class="col-12 d-flex">

        <a href="{{route('get.student.experience.index')}}"
           class="d-block w-100 btn bg-corporate-color text-white align-self-end">
            View List
        </a>
    </div>
</div>

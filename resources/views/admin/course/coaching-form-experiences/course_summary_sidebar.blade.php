<div class="row">
    <div class="col-12 text-center">
        <img src="{{asset('assets/img/logo_experiences.png')}}" class="img-fluid w-40" />
    </div>
    <div class="col-12 text-center">
        <span class="h3">Live Experiences</span>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-12">
        <span class="h6 fw-bold">Academic Dates</span>
    </div>
</div>

<div class="row mt-3">
    <div class="col-xl-4 opacity-75">
        <i class="fa fa-university fa-fw"></i> School
    </div>
    <div class="col-xl-8 ">{{$courseSummary->universityName()}}</div>
</div>

@if ($courseSummary->hasStartDate())
    <div class="row mt-3">
        <div class="col-xl-4 opacity-75">
            <i class="fa fa-calendar fa-fw"></i> Start date
        </div>
        <div class="col-xl-8">{{$courseSummary->startDate()->format('m/d/Y')}}</div>
    </div>
@endif

@if ($courseSummary->hasEndDate())
    <div class="row mt-3">
        <div class="col-xl-4 opacity-75">
            <i class="fa fa-calendar fa-fw"></i> End date
        </div>
        <div class="col-xl-8">{{$courseSummary->endDate()->format('m/d/Y')}}</div>
    </div>
@endif


@if ($courseSummary->isCourse())
    <div class="row mt-4">
        <div class="col-12">
            <span class="h6 fw-bold">Course Information</span>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-4 opacity-75">
            <i class="fa fa-chalkboard-teacher fa-fw"></i> Name
        </div>
        <div class="col-xl-8 ">
            {{$courseSummary->course()->name}}
        </div>
    </div>



    <div class="row mt-4">
        <div class="col-xl-4 opacity-75">
            Total sections
        </div>
        <div class="col-xl-8 d-flex justify-content-start">
            {{$courseSummary->course()->section->count()}}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 opacity-75">
            <hr>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-sm-4 col-md-6 col-xl-4">
        <span class="bg-white text-corporate-color rounded p-1 fw-bold">
             Price
        </span>
        </div>
        <div class="col-12 col-sm-8 col-md-6 col-xl-8 mt-3  mt-sm-0">
            <span class="bg-white text-corporate-color rounded p-1 fw-bold">{{$courseSummary->formatPrice($courseSummary->course()->price())}}</span>
        </div>
    </div>

@endif

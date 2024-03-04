<div class="row">
    <div class="col-12">
        <h5>{{$enrollment->course()->name}}</h5>
        <h6 class="text-corporate-dark-color">{{$enrollment->section->name}}</h6>
        <h6 class="text-corporate-color">{{$enrollment->course()->university->name}}</h6>

    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <h6>Prof. {{$enrollment->section->instructor->writeFullNameAndLastName()}}</h6>
        <h6 class="text-muted small">{{$enrollment->user->country->name}} - {{$enrollment->user->timezone->name}}</h6>


    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-xl-6">
        <p class="text-corporate-dark-color d-flex align-items-center mb-0">
            <i class="fa fa-circle fa-sm me-2"></i>
            <span class="d-inline-block">{{$enrollment->course()->conversationPackage->number_session}} Sessions</span>
        </p>

        <p class="text-corporate-dark-color d-flex align-items-center mb-0">
            <i class="fa fa-circle fa-sm me-2"></i>
            <span class="d-inline-block">{{$enrollment->course()->conversationPackage->sessionType->name}}</span>
        </p>

        <p class="text-corporate-dark-color d-flex align-items-center">
            <i class="fa fa-circle fa-sm me-2"></i>
            <span class="d-inline-block">{{$enrollment->course()->conversationPackage->sessionDuration()->get()}} Minutes</span>
        </p>

    </div>
</div>

<div class="row mb-5">
    <div class="col-12">
        <span class="text-muted d-block mb-0">Coaching Dates</span>
        <span class="d-inline-block">
            {{toDate($enrollment->course()->firstDate())}} - {{toDate($enrollment->course()->lastDate())}}
        </span>
    </div>
</div>

@if ( ! $enrollment->isActive())

    <div class="row mb-5">
        <div class="col-12">
            <span class="d-block mb-0">
                <span class="text-corporate-danger fw-bold">{{$enrollment->status->description()}}</span>
                <span class="ms-2">at</span>
                <span class="ms-2">{{toDatetimeInOneRow($enrollment->status_at, $timezone->name)}}</span>
            </span>
        </div>

        @if ($enrollment->status->isChanged() AND $enrollment->enrollmentTarget)
            <div class="col-12 mt-1">
                <span class="me-2">to</span>
                <span class="text-muted font-italic">{{$enrollment->enrollmentTarget->course()->name}}</span>
            </div>
        @endif

    </div>
@endif

<div class="row mt-4  position-absolute w-100" style="bottom:20px;">
    <div class="col-12 d-flex ">
        <a href="{{route('get.student.enrollment.show', $enrollment->hashId())}}"
           class="d-block w-100 btn bg-corporate-color text-white">
            View Course
        </a>
    </div>
</div>

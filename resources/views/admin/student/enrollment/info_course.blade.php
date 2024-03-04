<div class="card">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-headphones"></i> Course</span>
    </div>
    <div class="card-body padding-05-rem">

        <div class="row">
            <div class="col-md-6">
                <p class="my-0">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Course</span>
                    <a href="{{route('get.admin.course.show', $enrollment->course()->id)}}"
                       target="_blank"
                       class="d-inline-block"
                       title="Go to course">
                        {{$enrollment->course()->name}}
                    </a>
                </p>
            </div>

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">University</span>
                    <a href="{{route('get.admin.university.show', $enrollment->university()->id)}}"
                       target="_blank"
                       class=""
                       title="Go to university">
                        {{$enrollment->university()->name}}
                    </a>
                </p>
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Section</span>
                    {{$enrollment->section->name}}
                </p>
            </div>

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Instructor</span>
                    <a href="{{route('get.admin.instructor.show', $enrollment->section->instructor_id)}}"
                       target="_blank"
                       class="d-inline-block" title="Go to instructor">
                        {{$enrollment->section->instructor->writeFullName()}}
                    </a>
                </p>
            </div>
        </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <p class="my-0 ">
                        <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Status</span>
                    </p>
                    <p class="my-0 {{$enrollment->isActive() ? 'text-success' : 'text-danger'}}">
                        <span class="d-block">{{$enrollment->status->name}}</span>
                        <span class="d-block small ">
                            {!! toDatetimeInOneRow($enrollment->status_at, $timezone->name) !!}
                        </span>
                    </p>

                    @if ($enrollment->hasEnrollmentOrigin())
                        <p class="mt-1">
                            From: <span class="fw-bold">{{$enrollment->enrollmentOrigin->course()->name}}</span>
                        </p>
                    @endif
                </div>


                @if ($enrollment->accommodation)

                <div class="col-md-6">
                    <p class="my-0 ">
                        <span class="small d-inline-block text-danger fw-bold d-block ">Accommodation</span>
                    </p>
                    <p>
                        {{$enrollment->accommodation->description}}
                    </p>
                </div>

                @endif
            </div>

    </div>
</div>

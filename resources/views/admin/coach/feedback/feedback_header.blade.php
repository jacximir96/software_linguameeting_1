<div class="card">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-headphones"></i> Course</span>
    </div>
    <div class="card-body padding-05-rem">

        <div class="row">
            <div class="col-md-3">
                <p class="my-0">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Coach</span>
                    <span>{{$coach->writeFullName()}}</span>
                </p>
            </div>

            <div class="col-md-2">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Language</span>
                    <span>{{$wrapper->language()->name}}</span>
                </p>
            </div>

            <div class="col-md-3">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Date</span>
                    <span>{{$wrapper->printMoment()}}</span>
                </p>
            </div>

            <div class="col-md-2">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Recording</span>
                    @if ($wrapper->hasRecordingUrl())
                        <a href="{{$wrapper->get()->recording_url}}" target="_blank" title="Show recording" >
                            <i class="fa fa-play"></i>
                        </a>
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="col-md-2">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Download</span>
                    <a href="{{route('get.admin.coach.coach_feedback.download', $wrapper->get()->id)}}" title="Download feedback" >
                        <i class="fa fa-download"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

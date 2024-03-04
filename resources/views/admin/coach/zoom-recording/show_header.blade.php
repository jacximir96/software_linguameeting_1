<div class="card">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-headphones"></i> Zoom Recording</span>
    </div>
    <div class="card-body padding-05-rem">

        <div class="row">

            <div class="col-sm-3">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Start</span>
                    <span class="d-block-inline">{{toDate($recording->start)}}</span> -
                    <span class="d-block-inline">{{toTime24h($recording->start)}}</span>
                </p>
            </div>

            <div class="col-sm-3">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">End</span>
                    <span class="d-block-inline">{{toDate($recording->end)}}</span> -
                    <span class="d-block-inline">{{toTime24h($recording->end)}}</span>
                </p>
            </div>

            <div class="col-sm-2">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Recording</span>

                    <a href="{{$recording->play_url}}" target="_blank" title="Show Recording" >
                        <i class="fa fa-play"></i>
                    </a>

                </p>
            </div>

            <div class="col-sm-2">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Download</span>
                    <a href="{{$recording->download_url}}" title="Download Recording" >
                        <i class="fa fa-download"></i>
                    </a>
                </p>
            </div>

            <div class="col-sm-2">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Status</span>
                    @if ($recording->isCompleted())
                        <span class="text-success badge bg-success text-white">Completed</span>
                    @else
                        {{$recording->status}}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

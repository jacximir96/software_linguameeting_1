<div class="card mt-3">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-cogs"></i> Makeups and extra sessions</span>
    </div>
    <div class="card-body padding-05-rem">


        <div class="row">
            @if ($enrollment->isActive())
            <div class="col-12 text-end">
                <a href="{{route('get.admin.student.makeup.create', $enrollment->id)}}"
                   class="open-modal me-3 small text-success"
                   data-modal-reload="yes"
                   data-reload-type="parent"
                   data-modal-size="modal-md"
                   data-modal-title='Add Makeup'
                   title="Add Makeup">
                    <i class="fa fa-plus"></i>Add Makeup
                </a>
                <a href="{{route('get.admin.student.extra_session.create', $enrollment->id)}}"
                   onclick="return confirm('Are you sure to add one extra session?');"
                   class="small text-success">
                    <i class="fa fa-plus"></i>Add extra session
                </a>
            </div>
                @else
                <div class="col-12">
                    <span class="fw-bold text-secondary small">This enrollment is not active. </span>
                </div>
            @endif
            <div class="col-12">
                <hr class="my-1" style="color:#bbb;">
            </div>
        </div>

        <div class="row">
            @foreach ($viewData->otherSessionsAvailable() as $otherSession)
                <div class="col-12">
                    @include('admin.student.enrollment.extra_session', ['otherSession' => $otherSession])
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
</div>

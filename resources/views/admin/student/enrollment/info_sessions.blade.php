<div class="card h-100">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-book-reader"></i> Sessions</span>
    </div>
    <div class="card-body padding-05-rem">

        @if ($viewData->enrollment()->enrollmentSession->count())
            @foreach ($enrollmentSessions as $enrollmentSession)
                <div class="row mb-0">
                    @include('admin.student.enrollment.session', ['enrollmentSession' => $enrollmentSession])
                </div>
            @endforeach
        @else
            <span class="fw-bold text-warning-dark d-block">Enrollment without configured sessions.</span>
        @endif
    </div>
</div>

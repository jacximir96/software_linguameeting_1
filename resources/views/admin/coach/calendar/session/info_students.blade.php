<div class="row mt-4">
    <div class="col-5">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-users"></i> Students</span>
    </div>
    <div class="col-7">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-book"></i> Assignments</span>
    </div>
</div>


<div class="row mt-2">
    <div class="col-5">

        @foreach ($viewData->sessionAssignment()->enrollmentsSession() as $enrollmentSession)
            <div class="row mt-2">
                <div class="col-12">
                    @include('admin.coach.calendar.session.enrollment_session_info', ['enrollmentSession' => $enrollmentSession])
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-7">
        @if ($viewData->sessionAssignment()->hasAssignment())
            @include('admin.coach.calendar.session.info_assignment', ['assignment' => $viewData->sessionAssignment()->assignment()])
        @else
            <p class="mt-1 text-danger">
                Assignments not exists for this session.
            </p>
        @endif
    </div>
</div>

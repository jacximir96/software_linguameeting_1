<div class="row mt-4">
    <div class="col-5">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-users"></i> Makeup Students</span>
    </div>
    <div class="col-7">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-book"></i> Makeup Assignments</span>
    </div>
</div>


<div class="row mt-2">
    @foreach ($viewData->makeupSessionsAssignments() as $makeupSessionAssignment)
        <div class="col-5">
            @forelse ($makeupSessionAssignment->enrollmentsSession() as $enrollmentSession)
                <div class="row mt-2">
                    <div class="col-12">
                        @include('admin.coach.calendar.session.enrollment_session_info', ['enrollmentSession' => $enrollmentSession])
                    </div>
                </div>
            @empty
                <div class="row mt-2">
                    <div class="col-12">
                        -
                    </div>
                </div>
            @endforelse
        </div>

        <div class="col-7">
            @if ($makeupSessionAssignment->hasAssignment())
                @include('admin.coach.calendar.session.info_assignment', ['assignment' => $makeupSessionAssignment->assignment()])
            @else
                <p class="text-danger">
                    Assignments not exists for this makeup session.
                </p>
            @endif
        </div>
    @endforeach
</div>

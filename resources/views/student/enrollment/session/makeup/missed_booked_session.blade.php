<div class="row ">
    <div class="col-12">
        <span class="d-block fw-bold bg-reschedule text-white p-1 rounded">
            Missed Session
        </span>
    </div>

    <div class="col-12 mt-4 ">

        <div class="row">
            <div class="col-xl-5 ">
                @include('student.enrollment.session.makeup.info_coach', ['coach' => $session->coach])
            </div>
            <div class="col-12 col-xl-7">
                @include('student.enrollment.session.makeup.header')
            </div>
        </div>

    </div>
</div>

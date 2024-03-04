<div class="row">

    <div class="col-12">
        <span class="d-block fw-bold ">
            <span class="text-corporate-dark-color">{{$enrollmentSession->enrollment->section->course->name}}</span>
        </span>

        <span class="d-block fw-bold mt-1">
            Session {{$enrollmentSession->session_order}} - {{toMonthDayAndYearExtend($session->createTime('start_time'))}}
        </span>

        @if ( ! $course->isFlex())
        <span class="d-block text-muted small">
            {{toMonthDayAndYear($enrollmentSession->coachingWeek->start_date, $utcTimezoneName)}}, {{toMonthDayAndYear($enrollmentSession->coachingWeek->end_date, $utcTimezoneName)}}
        </span>
        @endif
    </div>
</div>

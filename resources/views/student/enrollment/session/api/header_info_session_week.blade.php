<div class="row gx-0">
    <span class="d-block fw-bold bg-corporate-color text-white p-1 rounded">
        @if ($coachingWeek->isMakeup())
            <span class="d-inline-block me-2 fw-bold text-corporate-dark-color">Additional Week</span>
        @else
            @if ($isCreateBook)
                <span class="d-inline-block me-2 fw-bold">Session {{$coachingWeek->sessionOrder()}} - Week</span>
            @else
                <span class="d-inline-block me-2 fw-bold">Week {{$coachingWeek->sessionOrder()}}</span>
            @endif
        @endif
        <span class="d-inline-block me-2">From</span>
        <span class="fst-italic">{{toMonthDayAndYear($coachingWeek->start_date, $utcTimezoneName)}} to
                                {{toMonthDayAndYear($coachingWeek->end_date, $utcTimezoneName)}}</span>
    </span>
</div>

<div class="mb-3 small div-week" id="div-week-{{$coachingWeek->hashId()}}">
    <input type="radio"
           class="eventWeekMake"
           data-week-id="{{$coachingWeek->hashId()}}"
           data-date-start="{{$coachingWeek->start_date->toDateString()}}"
           data-date-end="{{$coachingWeek->end_date->toDateString()}}"
           data-coaching-week-session-url="{{route('get.student.api.session.get.coaching_week', [$course->hashId(), $coachingWeek->sessionOrderObject()->get()])}}"
           name="week"
           value="{{$coachingWeek->hashId()}}">

    @if ($coachingWeek->isMakeup())
        <span class="d-inline-block me-2 fw-bold text-corporate-dark-color">Additional Week</span>
    @else
        <span class="d-inline-block me-2 fw-bold">Week {{$coachingWeek->sessionOrder()}}</span>
    @endif
    <span class="d-inline-block me-2">From</span>
    <span class="fst-italic">
                        {{toMonthDayAndYear($coachingWeek->start_date, $utcTimezoneName)}} to {{toMonthDayAndYear($coachingWeek->end_date, $utcTimezoneName)}}
                    </span>

    @if ($coachingWeek->isMakeup())
        <span class="d-block">
                            Although we recommend completing make-up sessions throughout your LinguaMeeting coaching course at your earliest convenience,
                            <span class="fw-bold">this is an additional week
                                selected by your instructor</span> to fulfil remaining make-up sessions past your LinguaMeeting course end date.
                        </span>
    @endif
</div>

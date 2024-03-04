<div class="row">
    <div class="col-12">
        <span class="d-block small text-decoration-underline bg-corporate-color-light fw-bold p-1">
            Select the week where you want to use the Make-up.
        </span>
    </div>
</div>

<div class="row mt-3 ">
    <div class="col-12">

        @if ($course->onlyWeekMakeups())

            @php $currentCoachingWeek = $course->obtainCoachingWeekFromToday() @endphp

            @if ($currentCoachingWeek)

                @include('student.enrollment.session.makeup.coaching_week_selector', ['coachingWeek' => $currentCoachingWeek])

            @else
                <p class="text-danger">
                    Due to the course selections set by your instructor, you are only allowed to complete make-ups during the original session dates.
                </p>

            @endif

        @else

            @foreach ($course->coachingWeeksOrdered() as $coachingWeek)

                @if ($coachingWeek->isPast())
                    @continue
                @endif

                @include('student.enrollment.session.makeup.coaching_week_selector', ['coachingWeek' => $coachingWeek])

            @endforeach

        @endif
    </div>
</div>

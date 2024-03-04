<div class="col-xl-1">

    <a href="#" class="">
        <div class="circle-icon">
            <i class="fa fa-book fa-lg text-white"></i>
        </div>
    </a>
</div>

<div class="col-xl-8">

    <span class="d-block fw-bold">
        {{$sessionWeek->writeSessionNumber()}}
    </span>

    @if ($sessionWeek->hasPeriod())
        <span class="d-block text-muted small">
            {{toMonthDayAndYear($sessionWeek->start_date, 'UTC')}}, {{toMonthDayAndYear($sessionWeek->end_date, 'UTC')}}
        </span>
    @endif
</div>

@if ($enrollment->isActive())
    <div class="col-xl-3 text-end">

        @if ($sessionWeek->isPast())

            @if ($makeupAvailability->hasMakeupAvailable())

                <a href="{{route('get.student.session.book.makeup.use.no_booked_session', [$enrollment->hashId(), $sessionWeek->sessionOrderObject()->get()])}}"
                   class="btn btn-sm bg-reschedule text-white d-inline-block m-2"
                   title="Use Make-up">
                    Make-up
                </a>
            @endif

        @else
            <a href="{{route('get.student.session.book.create.search_coach', [$enrollment->hashId(), $sessionWeek->sessionOrderObject()->get()])}}"
               class="btn btn-sm bg-corporate-color text-white me-2">
                Book Session
            </a>
        @endif


    </div>

@endif

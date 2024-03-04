<div class="col-xl-1">
    <a href="#" class="">
        <div class="circle-icon">
            <i class="fa fa-book fa-lg text-white"></i>
        </div>
    </a>
</div>

<div class="col-xl-8">

    <span class="d-block fw-bold">
        {{$flexSession->writeSessionNumber()}}
    </span>

    @if ($flexSession->hasPeriod())
        <span class="d-block text-muted small">
            {{toMonthDayAndYear($sessionWeek->start_date, 'UTC')}}, {{toMonthDayAndYear($sessionWeek->end_date, 'UTC')}}
        </span>
    @endif
</div>

@if ($enrollment->isActive())
    <div class="col-xl-3 text-end">
        <a href="{{route('get.student.session.book.create.search_coach', [$enrollment->hashId(), $flexSession->sessionOrderObject()->get()])}}" class="btn btn-sm bg-corporate-color text-white me-2">
            Book Session
        </a>
    </div>
@endif

<div class="row">

    <div class="col-12">
        <span class="d-block fw-bold ">
            <span class="text-corporate-dark-color">Course <span class="">{{$enrollment->course()->name}}</span></span>
        </span>
        @if ( ! $course->isFlex())
            <span class="text-muted small">
                {{$enrollment->course()->start_date->format('m/d/Y')}} - {{$enrollment->course()->end_date->format('m/d/Y')}}
            </span>
        @endif
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <span class="d-block fw-bold mt-1">
            Session {{$sessionOrder->get()}}
        </span>

        @if ( ! $course->isFlex())
            <span class="d-block text-muted small">
                {{toMonthDayAndYear($enrollment->course()->start_date, $utcTimezoneName)}}, {{toMonthDayAndYear($enrollment->course()->end_date, $utcTimezoneName)}}
            </span>
        @endif
    </div>
</div>

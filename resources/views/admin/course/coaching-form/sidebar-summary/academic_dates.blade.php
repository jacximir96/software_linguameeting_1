<div class="row">
    <div class="col-12">
        <span class="h6 fw-bold">Academic Dates</span>
    </div>
</div>

<div class="row mt-3">
    <div class="col-xl-4 opacity-75">
        <i class="fa fa-university fa-fw"></i> School
    </div>
    <div class="col-xl-8 ">{{$courseSummary->universityName()}}</div>
</div>

@if ($courseSummary->hasStartDate())
    <div class="row mt-3">
        <div class="col-xl-4 opacity-75">
            <i class="fa fa-calendar fa-fw"></i> Start date
        </div>
        <div class="col-xl-8">{{$courseSummary->startDate()->format('m/d/Y')}}</div>
    </div>
@endif

@if ($courseSummary->hasEndDate())
    <div class="row mt-3">
        <div class="col-xl-4 opacity-75">
            <i class="fa fa-calendar fa-fw"></i> End date
        </div>
        <div class="col-xl-8">{{$courseSummary->endDate()->format('m/d/Y')}}</div>
    </div>
@endif

@if ($courseSummary->hasHolidays())

    <div class="row mt-3">
        <div class="col-xl-4 opacity-75">
            <i class="fa fa-umbrella-beach fa-fw"></i> Holidays
        </div>
        <div class="col-xl-8">
            @if ($courseSummary->hasHolidays())
                {{ $courseSummary->holidays()->implode(function ($holiday){return $holiday->format('m/d/Y');},', ') }}
            @else
                No holidays
            @endif
        </div>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Browser periods in flex course ({{$course->start_date->format('d/M/y')}} to {{$course->end_date->format('d/M/Y')}})</h6>
            </div>
            <div class="card-body padding-05-rem">
                <div class="row">
                    <div class="col-6 text-center">
                        @if ($currentPeriod AND $course->period()->getStartDate()->startOfWeek()->startOfDay()->lessThan($currentPeriod->subDayFromStart()))
                            <a href="{{route('get.admin.course.schedule.browser', [$course->id, $currentPeriod->get()->getStartDate()->subDay()->startOfWeek()->toDateString()])}}"
                               title="Prev Week"
                               class="text-corporate-dark-color">
                                <i class="fa fa-arrow-left fa-2x"></i>
                            </a>
                        @else
                            <i class="fa fa-arrow-left fa-2x text-muted"></i>
                        @endif
                    </div>
                    <div class="col-6 text-center">

                        @if ($currentPeriod AND $course->period()->getEndDate()->endOfDay()->greaterThan($currentPeriod->get()->getEndDate()))

                            <a href="{{route('get.admin.course.schedule.browser', [$course->id, $currentPeriod->get()->getEndDate()->addDay()->toDateString()])}}"
                               class="text-corporate-dark-color" title="Next Week">
                                <i class="fa fa-arrow-right fa-2x"></i>
                            </a>
                        @else
                            <i class="fa fa-arrow-right fa-2x text-muted"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

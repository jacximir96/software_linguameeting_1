<div class="card mb-4 bg">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fa fa-fw fa-calendar-week me-2"></i> Sessions Dates
        </span>
    </div>
    <div class="card-body  d-none d-md-block">

        <div class="col-12 mb-3 ps-2 d-none d-lg-block">

            <table class="table table-responsive">
                <thead>
                <tr class="text-corporate-color">
                    <th class="text-center">Session</th>
                    <th class="text-center">Start date</th>
                    <th class="text-center">Due date</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($coachingWeeks as $coachingWeek)
                    <tr class="small">
                        <td class="text-center">

                            @if ($coachingWeek->isMakeup())
                                Additional Make-up Period
                            @else
                                {{$coachingWeek->session_order}}
                            @endif
                        </td>
                        <td class="text-center">{{$coachingWeek->start_date->toFormattedDateString()}}</td>
                        <td class="text-center">{{$coachingWeek->end_date->toFormattedDateString()}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="col-12 d-block d-lg-none">
            <div class="row ps-2">

                @foreach ($coachingWeeks as $coachingWeek)
                    <div class="col-12 mb-3 ps-2">
                        <div class="row">
                            <div class="col-12">
                        <span class="fw-bold fst-italic">
                            @if ($coachingWeek->isMakeup())
                                Additional Make-up Period
                            @else
                                Session {{$coachingWeek->session_order}}
                            @endif
                        </span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6 col-sm-4">
                                <span class="fw-bold text-corporate-color">Start date</span>
                            </div>
                            <div class="col-6 col-sm-8">
                                <span class="fst-italic">{{$coachingWeek->start_date->toFormattedDateString()}}</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6 col-sm-4">
                                <span class="fw-bold text-corporate-color">Due date</span>
                            </div>
                            <div class="col-6 col-sm-8">
                                <span class="fst-italic">{{$coachingWeek->end_date->toFormattedDateString()}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>



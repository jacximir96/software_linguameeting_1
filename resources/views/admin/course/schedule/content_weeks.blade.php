@include('admin.course.schedule.section_weeks_browser')

@include('admin.course.schedule.section_coaches')

<div class="card my-3">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <h6 class="m-0 font-weight-bold"><i class="fa fa-calendar-week"></i> Schedule</h6>

        <a href="#" class="text-corporate-dark-color fw-bold small text-decoration-underline" id="show-all-sessions-link">Remove Filters</a>
    </div>
    <div class="card-body">

        @if (isset($paginatorPeriod))
            <div class="row mb-2">
                <div class="col-12 col-sm-6 offset-sm-3 d-flex justify-content-between bg-corporate-color-lighter p-1 rounded">

                    @if ($paginatorPeriod->hasPrevPage ($page))
                        <a href="{{route('get.admin.course.schedule.browser_weeks', [$course->id, ($page-1), $periodKey ] )}}"

                           title="Next Week">
                            <i class="fa fa-arrow-left fa-2x"></i>
                        </a>
                    @else
                        <i class="fa fa-arrow-left fa-2x text-muted"></i>
                    @endif

                    @if ($paginatorPeriod->hasNextPage($page))
                        <a href="{{route('get.admin.course.schedule.browser_weeks', [$course->id, ($page+1), $periodKey ] )}}"
                           title="Prev Week">
                            <i class="fa fa-arrow-right fa-2x"></i>
                        </a>
                    @else
                        <i class="fa fa-arrow-right fa-2x text-muted"></i>
                    @endif

                </div>
            </div>


        @endif

        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center" style="width: 9%">Hour</th>
                @if ($currentPeriod)
                    @foreach ($currentPeriod->forPage($page) as $date)
                        <th style="width: 13%;">
                            <span class="d-block">{{$date->format('M d Y')}}</span>
                            <span class="d-block">{{$date->format('l')}}</span>
                        </th>
                    @endforeach
                @else
                    <th style="">Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                @endif

            </tr>
            </thead>
            <tbody>
            @if ($currentPeriod)

                @foreach ($viewData->schedule()->hoursTimeSorted() as $hourTime)

                    @php $sessionsByHour = $viewData->schedule()->sessionsSameHourByHour($hourTime) @endphp

                    <tr>
                        <td>
                            {{$hourTime->format('H:i')}}
                        </td>
                        @foreach ($currentPeriod->forPage($page) as $date)
                            <td class="text-center">
                                @include('admin.course.schedule.sessions_by_day', ['date' =>$date])
                            </td>
                        @endforeach
                    </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="8">
                        <span class="text-danger">El curso no tiene configuradas coaching weeks!</span>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

@include('admin.course.schedule.javascript')

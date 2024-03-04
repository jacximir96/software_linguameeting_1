<table class="table table-bordered text-center small mb-0 ">
    <thead class="sticky-top bg-light">
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
                    <span class="bg-corporate-color-light fw-bold p-1">
                        {{$hourTime->format('H:i')}}
                    </span>
                </td>
                @foreach ($currentPeriod->forPage($page) as $date)
                    <td class="text-center">
                        @include('student.enrollment.session.api.sessions_by_date', ['date' =>$date])
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

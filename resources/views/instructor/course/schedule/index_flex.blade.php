@extends('layouts.app_modal')

@section('content')

    @include('admin.course.schedule.section_flex_browser')

    @include('admin.course.schedule.section_coaches')

    <div class="row">
        <div class="col-12">
            <div class="card my-3">
                <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-calendar-week"></i> Schedule</h6>
                    <a href="#" class="text-corporate-dark-color fw-bold small text-decoration-underline" id="show-all-sessions-link">Remove Filters</a>
                </div>
                <div class="card-body padding-05-rem">
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 9%">Hour</th>
                            @if ($currentPeriod)
                                @foreach ($currentPeriod->get() as $date)
                                    <th style="width: 13%;"
                                        title="{{$course->period()->getStartDate()->eq($date) ? 'Start Course' : '' }} {{$course->period()->getEndDate()->startOfDay()->eq($date) ? 'End Course' : '' }}"

                                        class=" {{$course->period()->getStartDate()->eq($date) ? 'bg-corporate-color-light' : '' }}
                                        {{$course->period()->getEndDate()->startOfDay()->eq($date) ? 'bg-corporate-color-light' : '' }}">
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
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.course.schedule.javascript')

@endsection

@extends('layouts.app')

@section('content')

    @include('instructor.course.schedule.section_flex_browser')

    @include('instructor.course.schedule.section_coaches')

    <div class="row">
        <div class="col-12">
            <div style="height: 15px"></div>
            <div class="col-md-6">

                
                <div class="cursor_pointer custom-color-background-instructor padding-5" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        
                    <span class="text-corporate-dark-color align-svg">
                        <svg fill="#186e74" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34zm192-34l-136-136c-9.4-9.4-24.6-9.4-33.9 0l-22.6 22.6c-9.4 9.4-9.4 24.6 0 33.9l96.4 96.4-96.4 96.4c-9.4 9.4-9.4 24.6 0 33.9l22.6 22.6c9.4 9.4 24.6 9.4 33.9 0l136-136c9.4-9.2 9.4-24.4 0-33.8z"/></svg>
        
                    </span>
                    
                    @isset($courseSelected)
                        <span class="box_sessions_tag"><strong>{{$courseSelected->name}}</strong></span> 
                    @else
                    <span class="box_sessions_tag"><strong>All Courses</strong></span> 
                    @endisset

                    
                </div>
        
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton1">
                    <form method="GET">
                        <button type="submit" class="dropdown-item cursor_pointer" name="course" value="all">
                            All Courses
                        </button>
                    </form>
                    @foreach ($coursesList as $courseList)
                        <form method="GET">
                            <button type="submit" class="dropdown-item cursor_pointer" name="course" value="{{ $courseList->id }}">{{ $courseList->name }}</button>
                        </form>
                    @endforeach
                </div>        
            </div>
        
        </div>
        <div>                   
            <div class="card my-3">
                <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-calendar-week"></i> Schedule</h6>
                    {{-- <a href="{{route('get.instructor.course.schedule.index')}}" class="text-corporate-dark-color fw-bold small text-decoration-underline" id="show-all-sessions-link">Remove Filters</a> --}}
                    <a class="text-corporate-dark-color fw-bold small text-decoration-underline" href="{{route('get.instructor.course.schedule.index')}}">Remove Filters</a>
                </div>
                <div class="card-body padding-05-rem">
                    
                    <div class="table-container">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 9%">Hora</th>
                                    @for ($i = 0; $i < 7; $i++)
                                        <th style="width: 13%">
                                            {{ $startOfWeek->copy()->addDays($i)->toDateString() }}
                                            <br>
                                            {{ ucfirst($startOfWeek->copy()->addDays($i)->locale('en')->translatedFormat('l')) }}
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>    
                                <tr>
                                    <td colspan="8"></td>
                                </tr>
                                @for ($hour = 8; $hour <= 21; $hour++)
                                    @for ($minute = 0; $minute < 60; $minute += 30)
                                        <tr style="height: 50px">
                                            <td>
                                                {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($minute, 2, '0', STR_PAD_LEFT) }}
                                            </td>
                                            @for ($day = 0; $day < 7; $day++)
                                                <td class="text-center">
                                                    @foreach ($days as $session)
                                                        @php
                                                            $sessionDateTime = Carbon\Carbon::parse($session['day'] . ' ' . $session['start_time']);
                                                            $currentDateTime = $startOfWeek->copy()->addDays($day)->setHour($hour)->setMinute($minute);
                                                        @endphp
                                                        @if ($currentDateTime->eq($sessionDateTime))
                                                            
                                                            @include('instructor.course.schedule.sessions_by_day')
                                                            
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endfor
                                        </tr>
                                        @if (($minute == 30 || $minute == 0) && $hour <= 21)
                                            <tr>
                                                <td colspan="8"><hr></td>
                                            </tr>
                                        @endif
                                    @endfor
                                @endfor
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
        </div>
    </div>

    @include('instructor.course.schedule.javascript')
    <style>
        .table-container {
            max-height: 800px; 
            overflow-y: auto; 
        }

        .table thead th {
            position: sticky; 
            top: 0;
            z-index: 1; 
            background-color: #eef7f7; 
            font-weight: bold;
            color: black !important;
        }
    </style>
@endsection
@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
           <span class="">
                <i class="fas fa-search me-1"></i>
                Search Courses
            </span>
        </div>
        <div class="card-body">
            @include('coach.course.search_form')
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-headphones me-1"></i>
                Courses
            </span>

        </div>
        <div class="card-body">


            <table id="" class="table table-hover">
                <thead>
                <tr>
                    <th>University</th>
                    <th>Course</th>
                    <th>Sections</th>
                    <th>Course<br>Start Date</th>
                    <th>Course<br>End Date</th>
                    <th>Coaching Start</th>
                    <th>Coaching End</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($coursesCoach as $courseCoach)
                    @php $course = $courseCoach->course @endphp

                    <tr>
                        <td>{{$course->university->name}}</td>
                        <td>
                            <a href="{{route('get.coach.course.show', $course->id)}}"
                               class="small open-modal"
                               title="Show sections and documentation"
                               data-modal-size="modal-xl"
                               data-modal-title='Show sections and documentation'>
                                {{$course->name}}
                            </a>
                        </td>
                        <td>{{$course->section->count()}}</td>
                        <td>
                            {{$course->start_date->format('m/d/Y')}}
                        </td>
                        <td>
                            {{$course->end_date->format('m/d/Y')}}
                        </td>
                        <td>
                            @if ($course->isFlex())
                                {{$course->start_date->format('m/d/Y')}}
                            @else
                                @if ($course->coachingWeek->count())
                                    {{$course->coachingWeeksOrdered()->first()->start_date->format('m/d/Y')}}
                                @else
                                    -
                                @endif
                            @endif

                        </td>
                        <td>
                            @if ($course->isFlex())
                                -
                            @else
                                @if ($course->coachingWeek->count())
                                    {{$course->coachingWeeksOrdered()->last()->end_date->format('m/d/Y')}}
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

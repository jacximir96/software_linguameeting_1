@extends('layouts.app_modal')

@section('content')
    <div class="row">
        <div class="col-12">
            @include('coach.course.session.info_course_weeks', ['course' => $course])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-6">
            @include('coach.course.session.info_weeks_sections')
        </div>
        <div class="col-6">
            @include('coach.course.session.info_weeks_assignments', ['course' => $course])
        </div>
    </div>


@endsection

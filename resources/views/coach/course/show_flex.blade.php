@extends('layouts.app_modal')

@section('content')
    <div class="row">
        <div class="col-12">
            @include('coach.course.session.info_course_flex', ['course' => $course])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 ">
            @include('coach.course.session.info_flex_sections')
        </div>
    </div>


@endsection

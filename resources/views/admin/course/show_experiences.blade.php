@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="col-xl-6">
            @include('admin.course.card.general_data_experiences',[
                'course' => $course
            ])
        </div>
        <div class="col-xl-6">
            @include('admin.course.card.sections_div_experiences', [
                    'sections' => $course->section,
                ])
        </div>
    </div>
@endsection

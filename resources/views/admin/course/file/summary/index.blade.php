@extends('layouts.app_pdf')

@section('content')

    @include('common.file.head')

    <div class="content">
        @include('admin.course.file.summary.header')

        @if ($viewData->course()->serviceType->isConversations())
            @include('admin.course.file.summary.course_info')
            @include('admin.course.file.summary.general_info')
        @elseif($viewData->course()->serviceType->isExperiences())
            @include('admin.course.file.summary.experiences_course_info')
            @include('admin.course.file.summary.experiences_general_info')
        @endif

        @include('admin.course.file.summary.sections')

    </div>
@endsection

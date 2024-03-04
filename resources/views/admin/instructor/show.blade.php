@extends('layouts.app')

@section('content')

    @include('user.row_status', ['user' => $data->commonResponse()->instructor()])


    <div class="row my-3">
        <div class="col-xl-6">
            @include('admin.instructor.card.personal_data',[
                'instructor' => $data->commonResponse()->instructor()
            ])

            @include('user.activity.activity_card', [
                'activity' => $data->commonResponse()->activity(),
                'user' => $data->commonResponse()->instructor()
               ])
        </div>

        <div class="col-xl-6">

            @include('admin.instructor.card.universities', [
                'instructor' => $data->commonResponse()->instructor(),
            ])

            @if ($data->hasCourses())
                @include('admin.instructor.card.courses', [
                  'courses' => $data->courses(),
                  'instructor' => $data->commonResponse()->instructor(),
                  'showUniversityName' => $data->commonResponse()->hasToShowUniversityName()
                ])
            @else
                @include('admin.instructor.card.no_data', [
                    'message' => "There are not active courses"
                ])
            @endif

            @if ($data->commonResponse()->hasSections())
                @include('admin.instructor.card.sections', [
                    'sections' => $data->commonResponse()->sections(),
                ])
            @else
                @include('admin.instructor.card.no_data', [
                    'message' => "There are not instructor's sections"
                ])
            @endif

            @if ($checkerRole->isTeachingAssistant($data->commonResponse()->instructor()->rol()))

                @if ($data->hasSectionsAsTeachingAssistant())
                    @include('admin.instructor.card.sections', [
                        'asAssistant' => true,
                        'sections' => $data->sectionsAsTeachingAssistant(),
                    ])
                @endif

            @endif


        @if ($data->commonResponse()->instructor()->instructorOf->count())
                @include('admin.instructor.card.instructor_of_by', [
                        'teachingAssistants' => $data->commonResponse()->instructor()->instructorOf,
                        'instructorOf' => true,
                        ])
            @endif

            @if ($data->commonResponse()->instructor()->instructedBy->count())
                @include('admin.instructor.card.instructor_of_by', [
                    'teachingAssistants' => $data->commonResponse()->instructor()->instructedBy,
                    'instructorOf' => false,
                    ])
            @else
                @include('admin.instructor.form.assign_instructor_to_assistant_action', [
                    'assistant' => $data->commonResponse()->instructor(),
                    'instructor' => $data->commonResponse()->instructor(),
                    ])
            @endif

        </div>
    </div>


@endsection

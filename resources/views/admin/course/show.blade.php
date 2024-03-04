@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="col-xl-6">
            @include('admin.course.card.general_data',[
                'course' => $course
            ])

            @include('admin.course.card.coaches',[
                'course' => $course
            ])

            @include('admin.course.card.surveys',[
                'course' => $course
            ])

            <div class="row mt-2">
                <div class="col-12">
                    @include('admin.course.card.experience')
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            @if ($course->isFlex())
                @include('admin.course.card.sessions_flex', [
                        'course' => $course,
                        'coachingWeeks' => collect()
                    ])
            @else
                @include('admin.course.card.sessions_dates', [
                        'course' => $course,
                        'coachingWeeks' => $course->coachingWeeksOrdered()
                    ])
            @endif

                @include('admin.course.card.sections_div', [
                        'sections' => $course->section,
                    ])


        </div>
    </div>


@endsection

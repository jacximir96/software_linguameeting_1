@extends('layouts.app')

@section('content')


    <div class="card">

        <div class="card-body container">

            <div class="row mt-2 mt-sm-4">

                <div class="col-md-6">

                    @include('instructor.course.summary.info_general')
                    
                    

                </div>

                <div class="col-md-6">

                    <div class="row">
                        <div class="col-12 d-xl-none">
                            <div class="card p-3">
                                @include('admin.course.coaching-form.course-summary.sections', ['sections' => $course->section])
                            </div>
                        </div>
                        <div class="col-12 d-none d-xl-block">
                            <div class="card p-3 d-none d-xl-block">
                                @include('admin.course.coaching-form.course-summary.sections_table', ['sections' => $course->section])
                            </div>
                        </div>
                    </div>


                    @if ($course->isFlex ())

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card p-3">
                                    @include('admin.course.coaching-form.course-summary.flex')
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card p-3">
                                    @include('admin.course.coaching-form.course-summary.sessions', ['coachingWeeks' => $course->coachingWeek])
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

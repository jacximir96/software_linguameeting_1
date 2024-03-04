@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">

            <div class="container-fluid">

                <div class="row gx-5 d-flex align-items-stretch">

                    <div class="col-xl-3 ">

                        @include('student.enrollment.info_course')

                        @include('student.enrollment.help')

                    </div>
                    <div class="col-xl-6">


                        <div class="row">

                            <div class="col-12">
                                <h5 class="p-1 rounded bg-corporate-color-light text-corporate-dark-color fw-bold">Your Sessions</h5>
                            </div>

                            <div class="col-12 mt-1">

                                @include('student.enrollment.sessions-bag.index', [
                                    'enrollment' => $viewData->enrollment(),
                                    'sessionsBag' => $viewData->sessionsBag(),
                                    'showSurvey' => $showSurvey,
                                    'viewSurvey' => $viewSurvey,
                                ])

                            </div>
                        </div>


                        @if ($viewData->experienceRegisters()->count())
                            <div class="row mt-5">
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h5 class="p-1 rounded bg-corporate-color-light text-corporate-dark-color fw-bold">Your Experiences</h5>
                                </div>
                                <div class="col-12">
                                    @include('student.enrollment.experiences', [
                                            'course' => $viewData->course(),
                                            'experienceRegisters' => $viewData->experienceRegistersSorted(),
                                            'student' => $viewData->student()
                                            ])

                                </div>
                            </div>
                        @endif

                        @if ($viewData->enrollment()->isActive())
                            <div class="row mt-5">

                                <div class="accordion accordion-flush mt-4">

                                    <div class="accordion-item p-2" style="border:1px solid #ddd !important;">

                                        <div class="row d-flex align-items-center">
                                            <div class="col-xl-3">
                                                <a href="{{route('get.student.experience.index')}}" class="" title="View Experiences">
                                                    <img src="{{asset('assets/img/logo_experiences.png')}}" class="img-fluid w-40"/>
                                                </a>
                                            </div>
                                            <div class="col-xl-6">
                                            <span class="d-block text-muted">{{toMonthDayYear($course->start_date, $timezone->name)}} - {{toMonthDayYear($course->end_date, $timezone->name)}}

                                                @if ( ! $course->serviceType->isExperiences())
                                                    <span class="d-block text-muted">[optional]</span>
                                                @endif

                                            </div>
                                            <div class="col-xl-3 text-end">
                                                <a href="{{route('get.student.experience.index')}}" class="btn bg-corporate-color btn-sm me-2 text-white" title="View Experiences">
                                                    View List
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="col-xl-3">
                        <div class="row">

                            <div class="col-12">
                                <h5 class="p-1 rounded bg-corporate-color-light text-corporate-dark-color fw-bold">Your Progress</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @include('student.enrollment.progress.index')
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>



@endsection

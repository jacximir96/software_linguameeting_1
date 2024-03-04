@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">

            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#information" type="button" role="tab" aria-controls="information" aria-selected="true">
                        Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#sections" type="button" role="tab" aria-controls="sections" aria-selected="false">
                        Sections/Attendance
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#coaches" type="button" role="tab" aria-controls="coaches" aria-selected="false">
                        Coaches/Feedbacks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="false">
                        Schedule
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                    @include('instructor.course.card.information')
                </div>
                <div class="tab-pane fade show active" id="sections" role="tabpanel" aria-labelledby="sections-tab">

                    <div class="row">
                        <div class="col-xl-10 offset-xl-1">
                            @include('instructor.course.card.sections_origin', ['course' => $course])
                        </div>

                    </div>

                </div>
                <div class="tab-pane fade" id="coaches" role="tabpanel" aria-labelledby="coaches-tab">

                    @include('instructor.course.card.coaches', ['coaches' => $coaches])

                </div>

                <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">

                    @include('instructor.course.card.schedule', ['coaches' => $coaches])

                </div>
            </div>


        </div>
    </div>
@endsection

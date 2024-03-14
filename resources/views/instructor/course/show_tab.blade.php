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
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="view-attendance-tab" data-toggle="modal" data-target="#view" type="button" role="tab" aria-controls="schedule" aria-selected="false">
                        View Attendance
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

            <div class="modal fade bd-example-modal-lg" id="view" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-tittle" style="color:white;"><span class="title-form">STUDENTS</span></h4>
                        </div>
                        <div class="modal-body">
                            @if ($students != [])
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($students as $student)
                                    <p><a href="{{route('get.instructor.students.show', $student->id)}}" style="color:black">{{$i}}.  {{$student->lastname}}, {{$student->name}}</a></p>
                                    @php
                                        $i = $i+1;
                                    @endphp
                                @endforeach
                            @else
                                <p>There are no students in this course.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="view">
                                <i class="fa fa-undo" style="font-size:15px;"></i>&nbsp;&nbsp;&nbsp;Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

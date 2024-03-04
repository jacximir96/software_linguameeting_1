@extends('layouts.app')

@section('content')

    @include('common.form_message_errors')

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="text-corporate-dark-color text-20 mt-1">{{$student->writeFullName()}}
                                    <span>
                                        <a class="text-corporate-color" href="#"><i class="fas fa-glasses"></i></a>
                                    </span>
                                </div>
                                <div class="text-18 mt-1">{{$enrollment->course()->name}}</div>
                                <div class="mt-1">{{$enrollment->section->name}}</div>
                                @if ($viewData->lastLogin()->hasMoment())
                                    <div class="text-corporate-dark-color mt-2"><u>Last Login: {{toMonthDayAndYear($viewData->lastLogin()->moment(), $timezone)}}</u></div>
                                @else
                                    <div class="text-corporate-dark-color mt-2"><u>Not login found</u></div>
                                @endif


                            </div>

                            <div class="col-md-6 text-center">
                                <div class="text-corporate-dark-color points-sessions">
                                    <strong>{{$viewData->countSessionsCompleted()}}/{{$viewData->numCourseSessions()->get()}} </strong>
                                    <span class="text-corporate-color"><i class="fas fa-check-circle"></i></span>
                                </div>
                                <div>Sessions Completed</div>
                            </div>
                        </div>

                        @foreach ($viewData->enrollmentSessions() as $enrollmentSession)
                            @if ($enrollmentSession->hasFeedback())
                                @include('instructor.students.card_session', ['enrollmentSession' => $enrollmentSession])
                            @endif
                        @endforeach

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div>
                                    <a class="text-corporate-dark-color"
                                       href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#info-rubric"
                                       title="Read Rubric"><u>LinguaMeeting Rubric</u></a>

                                    @include('common.modal_info', [
                                                'rubric' => $viewData->rubric(),
                                                'size' => 'modal-lg',
                                               'modalId' => 'info-rubric',
                                               'modalTitle' => "Rubric for Student's Participation",
                                               'path' => 'instructor.course.gradebook.rubric'
                                           ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-corporate-dark-color box_sessions_tag"><strong>Student Profile </strong></span>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input class="form-input-name form-control " name="name" type="text" value="{{$enrollment->user->name}}" readonly>
                            </div>
                            <div class="col-md-6">
                                <input class="form-input-lastname form-control " name="lastname" type="text" value="{{$enrollment->user->lastname}}" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input class="form-input-email form-control " name="email" type="text" value="{{$enrollment->user->email}}" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input class="form-input-country form-control " name="country" type="text" value="{{$enrollment->user->countryLiveOrOrigin()->name}}" readonly>
                            </div>
                            <div class="col-md-6">
                                <input class="form-input-timezone form-control " name="timezone" type="text" value="{{$enrollment->user->timezone->name}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body container">
                                <div class="text-corporate-dark-color text-16"><strong>Student Admin</strong></div>

                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="float-start pt-2 pe-2">
                                                Change course/section
                                            </div>
                                            {{ Form::model($changeSectionForm->model(),  [
                                                'class' => 'user',
                                                'url'=> $changeSectionForm->action(),
                                                'autocomplete' => 'off',
                                                'id' =>'change-section-form'
                                                ]) }}
                                                    <div class="float-start pe-2">
                                                        <input class="form-input-class form-control"
                                                               id="section-id"
                                                               name="section_id"
                                                               type="number" placeholder="Class ID" value{{old('section_id')}}>
                                                        @error('section_id')
                                                            <span class="custom-invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="float-start">
                                                        <a class="text-corporate-color text-20 cursor_pointer"
                                                           id="link-change-section">
                                                            <i class="fas fa-share"></i>
                                                        </a>
                                                    </div>
                                            {{Form::close()}}
                                        </div>

                                </div>

                                <div  class="mt-2 float-none">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="float-start pt-2 pe-2">
                                                Make-up sessions for purchase
                                            </div>
                                            <div class="float-start pe-2">
                                                <select id="num-makeups" class="form-input-select form-control form-select" name="make-ups" placeholder="Select quantity">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </div>
                                            <div class="float-start">
                                                <a class="text-corporate-color text-20"
                                                   href="#"
                                                   onclick="return confirm('Are you sure you want add make-up sessions for purchase?');"
                                                   id="link-add-makups">
                                                    <i class="fas fa-share"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div  class="mt-4 float-none">
                                    @include('instructor.students.accommodation_form')
                                </div>

                                <div  class="mt-4 float-none">

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="col-md-4">
                                                <a href="{{route('get.instructor.students.enrollment.section.change', $enrollment->hashId())}}"
                                                   class="btn btn-danger btn-bold form-control-xs px-4 colorWhite"
                                                   onclick="return confirm('Are you sure to remove this student?');">
                                                    Delete Student
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});

        $('#link-add-makups').on('click', function(e) {

            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{route('post.instructor.api.students.makeup.assign', $enrollment->hashId())}}',
                data: {
                    'num_makeups':$('#num-makeups').val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Manejar la respuesta del servidor aquí

                    $.notify("Make-up sessions assigned successfully.", {
                        className: "success",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                },
                error: function(xhr, status, error) {

                    $.notify(xhr.responseText, {
                        className: "error",
                        position: "top-center",
                        showDuration: 400,
                        hideDuration: 400,
                        autoHideDelay: 2000,
                    });
                }
            });
        });

        $('#link-change-section').on('click', function (e){

            e.preventDefault();

            var resultado = window.confirm("Are you sure you want change section?");

            if (resultado == false) {
              return;
            }

            var sectionId = $('#section-id').val()

            if (sectionId == ''){
                alert('Class ID type is required');
                return;
            }

            // check class ID has only numeric
            var regex = /^[0-9]+$/;
            if ( ! regex.test(sectionId)) {
                alert("The class ID must have a numeric value");
                return;
            }

            $('#change-section-form').submit()
        });
    });

</script>


@endsection

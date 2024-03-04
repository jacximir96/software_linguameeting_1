@extends('layouts.app')

@section('content')


    <div class="card">

        @include('admin.course.coaching-form.header_card')

        <div class="card-body container">

            @include('admin.course.coaching-form.wizard_step', ['step' => 3])

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'academic_dates'
           ]) }}

            <div class="row mt-5">
                <div class="col-md-8">

                    @include('admin.course.coaching-form.title', [
                        'title' => 'Coaching Weeks',
                        'showPricing' => false
                    ])

                    @if ( ! $allowsFullEdition)
                        @include('admin.course.coaching-form.warning_no_full_edition')
                    @endif

                    <div class="row  mt-3 mt-sm-2 ">
                        <div class="col-12">
                            <span class="title-field-form d-block"><i class="fa fa-calendar-day fa-fw"></i> Flex Option</span>

                            <div class="form-check form-switch mt-3 {{ $errors->has('is_flex') ? ' div-invalid ' : ''}}">
                                @if ($allowsFullEdition)
                                    <input type="hidden" name="is_flex" value="0"/>
                                    {{Form::checkbox('is_flex', 1, null, ['class' => 'form-check-input form-swith', 'id' => 'checkboxFlexOption', 'onclick' => "eventFlexCheck();"])}}
                                @else
                                    {{Form::checkbox('is_flex', 1, null, ['class' => 'form-check-input form-swith', 'readonly' => true, 'disabled' => true])}}
                                @endif

                                <label class="form-check-label" for="flexSwitchCheckDefault">
                                    <span class="ms-1 title-color">Students are able to book sessions any time between the course start and end dates.</span>
                                </label>

                                @if ($allowsFullEdition)
                                    @error('is_flex')
                                    <span class="custom-invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 div-weeks {{$form->hideWeeks($course) ? 'd-none' : ''}}">

                        <div class="col-12">
                            <span class="title-field-form d-block"><i class="fa fa-calendar-alt fa-fw"></i> Session Dates</span>
                        </div>

                        @if ($errors->has('startDateSession.*') OR $errors->has('dueDateSession.*'))
                            <div class="col-12 custom-invalid-feedback fw-bold">
                                Please fill in all weeks with their start date and due date. This refers to the amount of time the student has to complete the specific session topic.
                            </div>
                        @endif

                        <div class="col-12 mt-3">
                            <div class="row p-2 rounded bg-corporate-color text-white fw-bold d-none d-sm-flex m-auto">
                                <div class="col-sm-4 ">Session</div>
                                <div class="col-sm-4">Start Date</div>
                                <div class="col-sm-4">Due Date</div>
                            </div>
                            @for ($numSession = 1; $numSession <= $course->conversationPackage->number_session; $numSession++ )
                                <div class="containter">

                                    <div class="row {{($numSession < $course->conversationPackage->number_session) ? 'mb-4' : ''}}  mt-sm-2 div-weeks {{ $errors->has('startDateSession') ? ' is-invalid ' : '' }}">
                                        <div class="col-sm-4  fw-bold">
                                            Session {{$numSession}}
                                        </div>

                                        <div class="col-sm-4">
                                            <span class=" small d-sm-none">Start date</span>
                                            <div class="input-group divIniWeek" id_calendar="{{$numSession}}">
                                                {{Form::text("startDateSession[".$numSession."]", null, [    'class' => 'form-control input-datepicker date-start',
                                                                                                        'id' => 'startDateSession'.$numSession,
                                                                                                        $allowsFullEdition ? '' : 'disabled' => $allowsFullEdition ? '' : 'disabled',
                                                                                                        'week_id' => $numSession ])}}
                                                <span class="input-group-text icon-calendar d-md-none d-xl-block"><i class="fa fa-calendar "></i></span>
                                            </div>
                                            @error('startDateSession.'.$numSession)
                                            <div class="row mt">
                                                <div class="col-12">
                                                    <span class="custom-invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>

                                                </div>
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-4 mt-2 mt-sm-0">
                                            <span class="small d-sm-none">End date</span>
                                            <div class="input-group divEndWeek" id_calendar="{{$numSession}}">
                                                {{Form::text("dueDateSession[".$numSession."]", null, [  'class' => 'form-control input-datepicker ',
                                                                                                'id' => 'dueDateSession'.$numSession,
                                                                                                $allowsFullEdition ? '' : 'disabled' => $allowsFullEdition ? '' : 'disabled',
                                                                                                'week_id' => $numSession ])}}
                                                <span class="input-group-text  icon-calendar d-md-none d-xl-block"><i class="fa fa-calendar "></i></span>
                                            </div>
                                            @error('dueDateSession.'.$numSession)
                                            <div class="row mt">
                                                <div class="col-12">
                                                    <span class="custom-invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            @endfor

                            @error('startDateSession')
                            <div class="row mt">
                                <div class="col-12">
                                    <span class="custom-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>

                                </div>
                            </div>
                            @enderror

                            {{Form::hidden('course_id', $course->id, ['id' => 'course_id'])}}
                            {{Form::hidden('dateStartHidden', $course->start_date->toDateString(), ['id' => 'dateStartHidden'])}}
                            {{Form::hidden('dateEndHidden', $course->end_date->toDateString(), ['id' => 'dateEndHidden'])}}
                        </div>


                    </div>

                    <div class="containter mt-4 div-make-ups  {{$form->hideWeeks($course) ? 'd-none' : ''}}">

                        <div class="row mb-4 mt-sm-2">
                            <div class="col-sm-4">
                                <p class=" mb-0 small">
                                    <span class="fw-bold">Additional Make-Up Period</span>
                                    <a href="#"
                                       class="fst-italic text-decoration-underline d-inline-block"
                                       data-bs-toggle="modal"
                                       data-bs-target="#makeup-info">
                                        <i class="fa fa-info-circle text-dark"></i>
                                    </a>
                                    @include('common.modal_info', [
                                        'modalId' => 'makeup-info',
                                        'modalTitle' => 'MakeUp info',
                                        'path' => 'admin.course.coaching-form.info_makeup'
                                    ])

                                    <span class="d-block subtitle-color fst-italic small fw-bold">*Optional</span>
                                </p>
                            </div>

                            <div class="col-sm-4">
                                <span class=" small d-sm-none">Start date</span>
                                <div class="input-group eventIniWeekMake">

                                    {{Form::text("startDateMake", null, [
                                                    'class' => 'form-control input-datepicker ',
                                                    $allowsFullEdition ? '' : 'disabled' => $allowsFullEdition ? '' : 'disabled',
                                                    'id'=>'startDateMake', ])}}
                                    <span class="input-group-text icon-calendar d-md-none d-xl-block"><i class="fa fa-calendar "></i></span>

                                </div>
                            </div>

                            <div class="col-sm-4 mt-2 mt-sm-0">
                                <span class="small d-sm-none">End date</span>
                                <div class="input-group eventEndWeekMake" id_calendar="{{$numSession}}">

                                    {{Form::text("dueDateMake", null, [
                                                    'class' => 'form-control input-datepicker ',
                                                    $allowsFullEdition ? '' : 'disabled' => $allowsFullEdition ? '' : 'disabled',
                                                    'id'=>'dueDateMake', ])}}
                                    <span class="input-group-text icon-calendar d-md-none d-xl-block"><i class="fa fa-calendar "></i></span>
                                </div>
                            </div>

                            @error('startDateMake')
                            <div class="row mt">
                                <div class="col-12">
                                    <span class="custom-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="row mt-5">

                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{route('get.admin.course.coaching_form.update.course_information', $course->id)}}"
                               title="Config Academic Dates"
                               class="btn  btn-bold px-4 bg-text-corporate-color text-white" >
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            <button class="btn  btn-bold px-4 bg-text-corporate-color text-white" type="submit">
                                Next <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>

                        {{Form::close()}}
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 ">
                    <div class="sticky-top bg-text-corporate-color text-white rounded p-2">
                        @include('admin.course.coaching-form.course_summary_sidebar')
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery.ajaxSetup({cache: false});

            $('.divIniWeek').each(function () {

                var date_ini_course = $('#dateStartHidden').val();
                var date_end_course = $('#dateEndHidden').val();

                var id_calendar = $(this).attr("id_calendar");

                $('#startDateSession' + id_calendar).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 1,
                    minDate: date_ini_course,
                    maxDate: date_end_course,
                    firstDay: 1
                });


                $('#startDateSession' + id_calendar).datepicker();

                $('#startDateSession' + id_calendar).datepicker().on("change", function () {

                    var newDate = moment($('#startDateSession' + id_calendar).val())
                    var newDate = newDate.add(1, 'days');

                    var dueDateId = '#dueDateSession'+id_calendar
                    $(dueDateId).datepicker("destroy");
                    $(dueDateId).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        numberOfMonths: 1,
                        minDate: newDate.format('YYYY-MM-DD'),
                        maxDate: date_end_course,
                        firstDay: 1
                    });
                    $(dueDateId).datepicker("refresh");
                });

            });

            $('.divEndWeek').each(function () {

                var date_ini_course = $('#dateStartHidden').val();
                var date_end_course = $('#dateEndHidden').val();
                var id_calendar = $(this).attr("id_calendar");

                $('#dueDateSession' + id_calendar).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 1,
                    minDate: date_ini_course,
                    maxDate: date_end_course,
                    firstDay: 1
                });


                $('#dueDateSession' + id_calendar).datepicker().on("change", function () {

                    var newDate = moment($('#dueDateSession' + id_calendar).val()).add(1, 'days');
                    $("#startDateMake").datepicker("destroy");
                    $('#startDateMake').datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        numberOfMonths: 1,
                        minDate: newDate.format('YYYY-MM-DD'),
                        maxDate: date_end_course,
                        firstDay: 1
                    });
                    $("#startDateMake").datepicker("refresh");

                    // Cambio el datepicker de inicio de la siguiente sesion
                    var newIdCalendar = parseInt(id_calendar) + 1;

                    $('.hasDatepicker').each(function () {

                        $('#startDateSession' + newIdCalendar).datepicker("destroy");
                        $('#startDateSession' + newIdCalendar).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            dateFormat: "yy-mm-dd",
                            numberOfMonths: 1,
                            minDate: newDate.format('YYYY-MM-DD'),
                            maxDate: date_end_course,
                            firstDay: 1
                        });
                        $("#startDateSession" + newIdCalendar).datepicker("refresh");

                        $('#dueDateSession' + newIdCalendar).datepicker("destroy");
                        $('#dueDateSession' + newIdCalendar).datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            dateFormat: "yy-mm-dd",
                            numberOfMonths: 1,
                            minDate: newDate.format('YYYY-MM-DD'),
                            maxDate: date_end_course,
                            firstDay: 1
                        });
                        $("#dueDateSession" + newIdCalendar).datepicker("refresh");

                        newIdCalendar = newIdCalendar + 1;
                    });
                });
            });

            createDateMakeIni = function () {

                var date_ini_course = $('#dateStartHidden').val();
                var date_end_course = $('#dateEndHidden').val();

                $('#startDateMake').datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 1,
                    minDate: date_ini_course,
                    maxDate: date_end_course,
                    firstDay: 1
                });


                $('#startDateMake').datepicker().on("change", function () {

                    var newDate = moment($('#startDateMake').val()).add(7, 'days');
                    var newDateEnd = moment($('#dateEndHidden').val());

                    if (newDateEnd < newDate) {
                        newDate = newDateEnd;
                    }

                    $("#dueDateMake").datepicker("destroy");
                    $('#dueDateMake').datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        numberOfMonths: 1,
                        minDate: $('#startDateMake').val(),
                        maxDate: newDate.format('YYYY-MM-DD'),
                        firstDay: 1
                    });
                    $("#dueDateMake").datepicker("refresh");

                });
            };

            createDateMakeEnd = function () {

                var date_ini_course = $('#dateStartHidden').val();
                var date_end_course = $('#dateEndHidden').val();

                $('#dueDateMake').datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 1,
                    minDate: date_ini_course,
                    maxDate: date_end_course,
                    firstDay: 1
                });


                $('#dueDateMake').datepicker();
            };


            eventFlexCheck = function () {

                if ($('#checkboxFlexOption').is(':checked')) {
                    $('.div-weeks').addClass('d-none');
                    $('.div-make-ups').addClass('d-none');

                } else {
                    $('.div-weeks').removeClass('d-none');
                    $('.div-make-ups').removeClass('d-none');
                }
            };


            $('.eventIniWeekMake').each(function () {
                createDateMakeIni();
            });

            $('.eventEndWeekMake').each(function () {
                createDateMakeEnd();
            });
        });
    </script>

@endsection

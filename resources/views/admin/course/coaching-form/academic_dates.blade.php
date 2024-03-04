@extends('layouts.app')

@section('content')


    <div class="card">
        @include('admin.course.coaching-form.header_card')
        <div class="card-body container">

            @include('admin.course.coaching-form.wizard_step', ['step' => 1])

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
                        'title' => 'Academic Dates',
                        'showPricing' => false
                    ])

                    @if ( ! $allowsFullEdition)
                        @include('admin.course.coaching-form.warning_no_full_edition')
                    @endif

                    <div class="row mt-3 mt-sm-2 ">
                        <div class="col-sm-6 col-xl-4">
                            <span class="title-field-form "><i class="fa fa-calendar-week fa-fw"></i> Term</span>
                            {{Form::select('semester_id', $form->optionsField('semesterOptions'),null, [
                                            'placeholder' => 'Select',
                                            'id' => 'semester_id',
                                            'class' => ' form-control form-select '.($errors->has('semester_id') ? ' is-invalid ' : '')],
                                            )}}

                            @error('semester_id')
                            <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-xl-4 offset-xl-1 mt-3 mt-sm-0">
                            <span class="title-field-form "><i class="fa fa-calendar fa-fw"></i> Year</span>
                            {{Form::select('year', $form->optionsField('yearsOptions'),null, [
                                            'placeholder' => 'Select',
                                            'id' => 'year',
                                            'class' => 'form-control form-select '.($errors->has('year') ? ' is-invalid ' : '')],
                                            )}}
                            @error('year')
                            <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-sm-6 col-xl-4">
                            <span class="title-field-form "><i class="fa fa-calendar-day fa-fw"></i> Start Date</span>

                            @if ($allowsFullEdition)
                                <div class="input-group">
                                    {{Form::text('start_date', null, ['id' =>'start-date', 'class' => 'form-control '. ($errors->has('start_date') ? 'is-invalid' : null)])}}

                                    <span class="input-group-text icon-calendar"><i class="fa fa-calendar "></i></span>
                                </div>
                                @error('start_date')
                                <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            @else
                                <div class="card">
                                    <div class="card-body bg-light p-2">
                                        <span class="fst-italic">{{toDate($course->start_date)}}</span>

                                        <i class="fa fa-lock fa-fw subtitle-color small" title="Since your course already has students registered, some fields of the coaching form are locked"></i>

                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-sm-6 col-xl-4 offset-xl-1 mt-3 mt-sm-0">
                            <span class="title-field-form "><i class="fa fa-calendar-day fa-fw"></i> End Date</span>

                            @if ($allowsFullEdition)
                                <div class="input-group">
                                    {{Form::text('end_date', null, [ 'class' => 'form-control  input-datepicker '. ($errors->has('end_date') ? 'is-invalid' : null)])}}
                                    <span class="input-group-text icon-calendar"><i class="fa fa-calendar"></i></span>
                                </div>

                                @error('end_date')
                                <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            @else

                                <div class="card">
                                    <div class="card-body bg-light p-2">
                                        <span class="fst-italic">{{toDate($course->end_date)}}</span>
                                        <i class="fa fa-lock fa-fw subtitle-color small" title="Since your course already has students registered, some fields of the coaching form are locked"></i>
                                    </div>
                                </div>

                            @endif
                        </div>

                    </div>

                    <div class="row  mt-4">

                        <div class="col-12">

                            <span class="title-field-form "><i class="fa fa-calendar-alt fa-fw"></i> Select Holidays</span>
                            <a href=""
                               class="ms-2 text-dark"
                               data-bs-toggle="modal" data-bs-target="#info-holidays"
                               title="More info">
                                <i class="fa fa-info-circle"></i>
                            </a>

                            @include('common.modal_info', [
                                       'modalId' => 'info-holidays',
                                       'modalTitle' => 'Holidays info',
                                       'path' => 'admin.course.coaching-form.info_holidays'
                                   ])

                        </div>

                        <div class="col-12 col-sm-6 col-xl-4 mt-2 mt-lg-0">
                            <div id="datepicker-multiple"></div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-4 mt-2 mt-lg-0 offset-xl-1">
                            <span class="title-field-form  fst-italic">Dates Selected</span>
                            <div class="dateSelected">
                                @forelse ($form->holidaysAsCarbonCollect() as $holiday)
                                    <div class="event_day_selected mb-2"
                                         day="{{$holiday->day}}"
                                         month="{{$holiday->month}}"
                                         year="{{$holiday->year}}"
                                         order="{{$holiday->getTimestampMs()}}">{{$holiday->toDateString()}}</div>
                                @empty
                                    <span class="d-block mt-2 small fst-italic no-selected-holidays subtitle-color">No holidays selected</span>
                                @endforelse
                            </div>

                            <div id="holidays_field">
                                @foreach ($form->holidaysAsCarbonCollect () as $holidayDate)
                                    <input type="hidden" name="holidays[]" value="{{$holidayDate->toDateString()}}"/>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if ($hasExperiences)
                        <div class="row mt-4">
                            <div class="col-12">
                                <span class="title-field-form "><i class="fa fa-photo-video fa-fw"></i> Experiences</span>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="rounded" style="background-color: #116B71;">
                                    <div class="row rounded">
                                        <div class="col-sm-6 col-xl-4 mt-3 d-flex align-items-center text-center">
                                            @if ($allowsFullEdition)

                                                {{Form::select('experience', $form->optionsField('experiencesOptions'),null, [
                                                            'id' => 'experience',
                                                            'class' => 'form-control form-select w-sm-50 ms-sm-3'.($errors->has('experience') ? ' is-invalid ' : '')],
                                                            )}}
                                                @error('experience')
                                                    <span class="custom-invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            @else

                                                <div class="card">
                                                    <div class="card-body bg-light p-2">

                                                        <i class="fa fa-lock fa-fw text-muted small"
                                                           title="Since your course already has students registered, some fields of the coaching form are locked"></i>

                                                        <span class="text-corporate-color fw-bold fst-italic">
                                                            {{$course->conversationPackage->writeExperienceOption()}} selected
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-sm-6 col-xl-4 mt-2 mt-sm-0 d-flex align-items-center text-center">
                                            <a href="https://www.linguameeting.com/experiences" class="ms-2 ms-sm-0" target="_blank" title="Show experiences">
                                                <img src="{{asset('assets/img/logo_experiences.png')}}" alt="Logo Experiences" class="w-100">
                                            </a>
                                        </div>

                                        <div class="col-12 col-xl-4 p-4">
                                            <p class="" style="color:#eb6464">Experiences only available in Spanish.</p>

                                            <p class="text-white">
                                                Would you like to add LinguaMeeting Experiences to your course?<br>
                                            </p>
                                            <p class="text-white">
                                                Click <a class="text-white" href="{{asset('storage/experiences.pdf')}}" target="_blank"><u>here</u></a>
                                                to learn more and or see Experiences in action <a class="text-white" href="https://www.linguameeting.com/experiences" target="_blank"><u>here</u></a>.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <p class="alert m-0 p-2">
                                            LinguaMeeting Experiences offer real time Zoom-style cultural events hosted by our coaches from the student portal.
                                            You can make Experiences for credit for students, or completely optional.
                                            The price for accessing unlimited Experiences is $15. Experiences available only in Spanish.
                                        </p>
                                        <p class="alert m-0 p-2">
                                            <span class="fw-bold d-block">The price for accessing unlimited Experiences is $15.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="row mt-3">

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-bold px-4 bg-text-corporate-color text-white" id="button_send" type="submit">
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

            jQuery(document).on('click', '.icon-calendar', function (event) {
                $(this).prev('#start-date').datepicker('show');
            });

            jQuery('#start-date').datepicker({
                changeMonth: true,
                dateFormat: "yy-mm-dd",
                numberOfMonths: 1,
                firstDay: 1,
                beforeShow: function (input, inst) {
                    jQuery('#datepicker-multiple').css('display', 'none')
                    //jQuery('#datepicker-multiple').fadeOut(500)
                },
                onClose: function () {
                    jQuery('#datepicker-multiple').css('display', 'block')
                    //jQuery('#datepicker-multiple').fadeIn(500)
                }
            });


            jQuery.ajaxSetup({cache: false});

            jQuery('#datepicker-multiple').multiDatesPicker({
                addDates: [{!! $form->writeHolidaysForCalendar() !!}],
                /*minDate: '2023-02-08',*/
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                onSelect: function (formattedDate, date, inst) {

                    var dayWasAlreadySelectedAbove = false;

                    $('.event_day_selected').each(function () {
                        //check if day was already selected above
                        var day_aux = $(this).attr('day');
                        var month_aux = $(this).attr('month');
                        var year_aux = $(this).attr('year');

                        var selectedMonth = parseInt(date.selectedMonth) + 1;

                        if (day_aux == date.selectedDay && month_aux == selectedMonth && year_aux == date.selectedYear) {
                            $(this).remove();
                            dayWasAlreadySelectedAbove = true;
                        }
                    });

                    if (!dayWasAlreadySelectedAbove) {

                        appendSelectedDayInCalendar(date)
                    }

                    orderDaysSelected()

                    createHolidaysFieldsForm()
                }
            });

            function appendSelectedDayInCalendar(date) {

                var selectedMonth = parseInt(date.selectedMonth) + 1;
                //selectedMonth = selectedMonth.toString().padStart(2, '0')
                var valueDateOrder = date.selectedYear + '-' + selectedMonth + '-' + date.selectedDay
                var valueDateOrder = new Date(valueDateOrder)
                valueDateOrder = valueDateOrder.getTime() //timestamp

                $('.dateSelected').append('' +
                    '<div class="event_day_selected mb-2" order="' + valueDateOrder + '" day="' + date.selectedDay + '" month="' + selectedMonth + '" year="' + date.selectedYear + '">'
                    + date.selectedYear + '-' + selectedMonth.toString().padStart(2, '0') + '-' + date.selectedDay.toString().padStart(2, '0')
                    + '</div>'
                );
            }

            function orderDaysSelected() {

                $('.dateSelected').append($('.dateSelected .event_day_selected').sort(function (a, b) {
                    return a.getAttribute('order') - b.getAttribute('order');
                }));
            }

            function createHolidaysFieldsForm() {

                $('#holidays_field').empty()

                $('.event_day_selected').each(function () {
                    //if day was already selected above -> add holidays input field
                    var day = $(this).attr('day');
                    var month = $(this).attr('month');
                    var year = $(this).attr('year');

                    var date = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0')

                    $('#holidays_field').append('<input type="hidden" name="holidays[]" ' + 'value="' + date + '" />');
                });

                var selectedDaysNumber = $('.event_day_selected').length;
                if (selectedDaysNumber > 0) {
                    jQuery('.no-selected-holidays').removeClass('d-block').removeClass('d-none').addClass('d-none')
                } else {
                    jQuery('.no-selected-holidays').removeClass('d-block').removeClass('d-none').addClass('d-block')
                }
            }
        });
    </script>

@endsection

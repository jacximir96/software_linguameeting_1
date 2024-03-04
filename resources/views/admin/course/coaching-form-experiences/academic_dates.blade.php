@extends('layouts.app')

@section('content')


    <div class="card">

        @include('admin.course.coaching-form.header_card')

        <div class="card-body container">

            @include('admin.course.coaching-form-experiences.wizard_step', ['step' => 1])

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'academic-dates-coaching-form-experiencs'
           ]) }}

            <div class="row mt-5">
                <div class="col-md-8">

                    @include('admin.course.coaching-form.title', [
                        'title' => 'School Information - Academic Dates',
                        'showPricing' => false
                    ])

                    @if ( ! $allowsFullEdition)
                        @include('admin.course.coaching-form.warning_no_full_edition')
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 col-xl-9">
                            <span class="title-field-form "><i class="fa fa-edit fa-fw"></i> Academic Course Title</span>
                            {{Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? ' is-invalid ' : '')])}}
                            @error('name')
                            <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <a href="https://www.linguameeting.com/futureExperiences#upcomingExperiences"
                               target="_blank"
                               title="See available experiences"
                                class="small">
                                See Availables Experiences Here
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3">
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
                                        <span class="fst-italic">{{$course->start_date->format('m/d/Y')}}</span>

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
                                        <span class="fst-italic">{{$course->end_date->format('m/d/Y')}}</span>
                                        <i class="fa fa-lock fa-fw subtitle-color small" title="Since your course already has students registered, some fields of the coaching form are locked"></i>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">

                        <div class="col-md-8 col-lg-4">
                            <span class="title-field-form "><i class="fa fa-photo-video fa-fw"></i> Experiences</span>
                            {{Form::select('experience_type_id', $form->optionsField('experienceTypeOptions'),null, [
                                            'placeholder' => 'Select Experience',
                                            'id' => 'experience_type_id',
                                            'class' => ' form-control form-select '.($errors->has('experience_type_id') ? ' is-invalid ' : '')],
                                            )}}
                            @error('experience_type_id')
                            <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 offset-xl-1 col-xl-4 mt-3 mt-sm-0">
                            <span class="title-field-form "><i class="fa fa-tag"></i> Discount</span>
                            <div class="input-group">
                                {{Form::number('discount', null, ['class' => 'form-control ', 'min' => 0, 'step' => '0.01'])}}
                                <div class="input-group-text"><i class="fa fa-dollar-sign fa-fw"></i></div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-8 col-lg-4">
                            <span class="title-field-form "><i class="fa fa-language fa-fw"></i> Select Language</span>
                            {{Form::select('language_id', $form->optionsField('languageOptions'),null, [
                                            'placeholder' => 'Select Language',
                                            'id' => 'language_id',
                                            'class' => ' form-control form-select '.($errors->has('language_id') ? ' is-invalid ' : '')],
                                            )}}
                            @error('language_id')
                                <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-8 col-lg-4 offset-lg-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="title-field-form "> Is LingroLearning?</span>
                                    <input type="hidden" name="is_lingro" value="0"/>
                                    {{Form::checkbox('is_lingro', 1, null, ['class' => 'form-check-input d-block'])}}
                                </div>

                                <div class="col-md-6">
                                    <span class="title-field-form "> Is open access?</span>
                                    <input type="hidden" name="is_free" value="0"/>
                                    {{Form::checkbox('is_free', 1, null, ['class' => 'form-check-input d-block'])}}
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="row mt-3">

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-bold px-4 bg-text-corporate-color text-white" id="button_send" type="submit">
                                Next <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>


                        {{Form::close()}}
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 h-100 ">
                    <div class="sticky-top bg-text-corporate-color text-white rounded p-2">
                        @include('admin.course.coaching-form-experiences.course_summary_sidebar')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery(document).on('click', '.icon-calendar', function (event){
                $(this).prev('#start-date').datepicker('show');
            });

            jQuery('#start-date').datepicker({
                changeMonth: true,
                dateFormat: "yy-mm-dd",
                numberOfMonths: 1,
                firstDay: 1,
                beforeShow: function(input, inst) {
                    jQuery('#datepicker-multiple').css('display', 'none')
                    //jQuery('#datepicker-multiple').fadeOut(500)
                },
                onClose: function() {
                    jQuery('#datepicker-multiple').css('display', 'block')
                    //jQuery('#datepicker-multiple').fadeIn(500)
                }
            });


            jQuery.ajaxSetup({cache: false});


        });
    </script>

@endsection

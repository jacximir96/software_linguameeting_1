@extends('layouts.app')

@section('content')


    <div class="card">

        @include('admin.course.coaching-form.header_card')

        <div class="card-body container">

            @include('admin.course.coaching-form.wizard_step', ['step' => 2])

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'school_information'
           ]) }}

            <div class="row mt-5">

                <div class="col-md-8">

                    @include('admin.course.coaching-form.title', [
                        'title' => 'Course Information',
                        'showPricing' => false
                    ])

                    @if ( ! $form->allowsFullEdition())
                        @include('admin.course.coaching-form.warning_no_full_edition')
                    @endif

                    <div class="row mt-3 mt-sm-2 py-3 rounded background-field">
                        <div class="col-12">
                            <span class="title-field-form "><i class="fa fa-edit fa-fw"></i> Academic Course Title</span>
                            {{Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? ' is-invalid ' : '')])}}
                        </div>
                    </div>

                    <div class="row mt-4 py-3 rounded background-field">

                        <div class="col-12 {{ $errors->has('session_type_id') ? ' div-invalid ' : ''}}">
                            <span class="title-field-form "><i class="fa fa-tag fa-fw"></i> Session Type</span>

                            @if ($form->allowsFullEdition())
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                {{Form::radio('session_type_id', $form->smallGroupId(), null, ['id' => 'small_group', 'class'=>'session_type'])}} Small Groups (approx 2-3)
                                            </div>

                                            <div class="col-lg-6 mt-3 mt-lg-0">
                                                {{Form::radio('session_type_id', $form->oneOnOneId(), null, ['id' => 'one_one_one', 'class'=>'session_type'])}} One-on-one
                                            </div>

                                            @error('session_type_id')
                                                <span class="custom-invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-body bg-light">
                                        <span class="fst-italic">{{$course->conversationPackage->sessionType->name}}</span>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    @if ($form->allowsFullEdition())
                        <div class="row mt-4 div_availability py-3 rounded background-field" id="div_availability">
                            @include('admin.course.coaching-form.course_availability', [
                            'availabilitySetup' => $form->availabilitySetup(),
                            'optionsCustomSessions' => $form->optionsCustomNumberSessions(),
                            ])
                        </div>
                    @else

                        <div class="row mt-4 py-3 rounded background-field">

                            <div class="col-12">
                                <span class="title-field-form "><i class="fa fa-clipboard-list fa-fw"></i> Number of Sessions</span>
                                <div class="card">
                                    <div class="card-body bg-light">
                                        <span class="fst-italic">{{$course->conversationPackage->number_session}} sessions</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 py-3 rounded background-field">
                            <div class="col-12">
                                <span class="title-field-form "><i class="fa fa-clock fa-fw"></i> Duration of Sessions</span>
                                <div class="card">
                                    <div class="card-body bg-light">
                                        <span class="fst-italic">{{$course->conversationPackage->duration_session}} minutes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4  py-3 rounded background-field">

                        <div class="col-md-8 col-lg-5">
                            <span class="title-field-form "><i class="fa fa-language fa-fw"></i> Select Language</span>
                            {{Form::select('language_id', $form->optionsField('languageOptions'),null, [
                                            'placeholder' => 'Select Language',
                                            'id' => 'language_id',
                                            'class' => ' form-control form-select '.($errors->has('language_id') ? ' is-invalid ' : '')],
                                            $form->dataAttributesLingroLanguage(),
                                            )}}
                        </div>

                    </div>

                    <div class="row mt-3 {{ ! $form->showLingroUserField() ? 'd-none' : ''}}  py-3 rounded background-field" id="div_lingro_user">

                        <div class="col-md-8 col-lg-5">
                            <span class="title-field-form ">Are you a LingroLearning user?</span>
                            {{Form::select('user_lingro', $form->optionsField('booleanOptions'),null, [
                                            'placeholder' => 'Select',
                                            'id' => 'user_lingro',
                                            'class' => 'dropdown_user_lingro form-control form-select '.($errors->has('user_lingro') ? ' is-invalid ' : '') ],
                                            )}}
                        </div>
                    </div>

                    <div class="row mt-3 {{ ! $form->showGuideField() ? 'd-none' : ''}}  py-3 rounded background-field" id="div_guide">
                        <div class="col-md-8 col-lg-5">
                            <span class="title-field-form ">Select Guide</span>
                            {{Form::select('guide_id', $form->optionsField('guideOptions'),null, [
                                            'placeholder' => 'Select',
                                            'id' => 'guide_id',
                                            'class' => 'dropdown_guide form-control form-select '.($errors->has('guide_id') ? ' is-invalid ' : '')]
                                            )}}
                        </div>
                    </div>

                    <div class="row mt-3  py-3 rounded background-field" id="div_makeup">

                        <div class="col-12 col-lg-5">
                            <span class="title-field-form ">Make-up Session</span>
                        </div>

                        <div class="col-12">
                            <p class="small pb-0 mb-1 subtitle-color">
                                Enable students to purchase make-ups.
                            </p>
                            <p class="small subtitle-color">
                                <strong>Make-Up Session Pricing:</strong> $5 Small Groups 30 min., $5 One-on-One 15 min., $10 One-on-One 30 min.
                            </p>
                        </div>

                        <div class="col-md-6 col-lg-5">
                            {{Form::select('number_makeups', $form->optionsField('makeUpSessions'),null, [
                                           'id' => 'number_makeups',
                                           'class' => 'dropdown_guide form-control form-select ']
                                           )}}
                        </div>
                        <div class="col-12 mt-4">
                            <span class="title-field-form">Only Week Make-up</span>

                            <p class="">
                                Only allow make-ups to be used during the original session's dates.
                                <input type="hidden" name="only_week_makeups" value="0"/>

                                {{Form::checkbox('only_week_makeups', 1, null, ['class' => 'form-check-input'])}}
                            </p>
                        </div>
                    </div>

                    @if (user()->hasAdminRoles())
                        <div class="row mt-4 pt-3 pb-3 bg-corporate-color-lighter">


                            <div class="col-12">
                                <span class=" text-primary fw-bold">
                                    To be filled out by the administrator
                                </span>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3 mt-3">
                                <span class="title-field-form ">Discount?</span>

                                <div class="input-group">
                                    <div class="input-group-text"><i class="fa fa-dollar-sign fa-fw"></i></div>
                                    {{Form::number('discount', null, ['class' => 'form-control ', 'min' => 0, 'step' => '0.01'])}}

                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3 mt-3">
                                <span class="title-field-form ">Students per session?</span>

                                <div class="input-group">
                                    <div class="input-group-text"><i class="fa fa-users fa-fw"></i></div>
                                    {{Form::number('student_class', null, [ 'id' => 'student_class',
                                                                        'class' => 'form-control  '.($errors->has('student_class') ? ' is-invalid ' : ''),
                                                                        'min' => 1,
                                                                        'step' => 1])}}

                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3 mt-3">
                                <span class="title-field-form "> Is open access?</span>
                                <input type="hidden" name="is_free" value="0"/>
                                {{Form::checkbox('is_free', 1, null, ['class' => 'form-check-input d-block'])}}
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3 mt-3">

                                <span class="title-field-form">Complimentary make-up</span>

                                <p class="">
                                    <input type="hidden" name="complimentary_makeup" value="0"/>

                                    {{Form::checkbox('complimentary_makeup', 1, null, ['class' => 'form-check-input'])}}
                                </p>
                            </div>
                        </div>

                    @endif

                    <div class="row mt-5">

                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{$form->backStepRoute()}}"
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


            jQuery(document).on('click', '.session_type', function (e) {

                var selectedVal = jQuery(this).val()

                writeDefaultStudentsPerSession(selectedVal)

                jQuery('.box_sessions').removeClass('box_sessions_selected').removeClass('div-disabled')

                jQuery('.box_session_custom').removeClass('box_sessions_selected').removeClass('div-disabled')

                jQuery('.box_duration').removeClass('box_sessions_selected').removeClass('div-disabled')

                jQuery('#number_session').val('')

                jQuery('#duration_session').val('')

                jQuery('.dropdown_sessions').val('')
            });

            function writeDefaultStudentsPerSession(selectedVal) {

                var smallGroupSessionTypeSelected = (selectedVal == 2)

                if (smallGroupSessionTypeSelected) {
                    jQuery('#student_class').val(4)  //magic number...
                } else {
                    jQuery('#student_class').val(1)  //magic number...
                }
            }


            /*****************************
             /** number sessions logic **
             /*****************************/
            var setupAvailability = {!! $form->availabilitySetup()->writeSetupThatUserCanSelect()->get() !!}

                /*
                        var setupAvailability = {"2":{  "30":{"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10,"11":11,"12":12},
                                                        "45":{"4":4,"6":6,"7":7}},
                                                "1":{   "15":{"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10,"11":11,"12":12},
                                                        "30":{"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10,"11":11,"12":12},
                                                        "45":{"4":4,"7":7}}}
                 */
                jQuery(document).on('click', '.box_sessions', function (e) {

                    e.preventDefault();

                    var numOfSessionsSelected = jQuery(this).data('num-sessions');

                    updateDurationOfSessionsStatusFromNumberOfSessionsSelected(numOfSessionsSelected)
                    jQuery('.dropdown_sessions').val('')


                    jQuery('.box_sessions').removeClass('box_sessions_selected').addClass('box_sessions_no_selected')
                    jQuery('.box_session_custom').removeClass('box_sessions_selected').addClass('box_sessions_no_selected')

                    jQuery(this).removeClass('box_sessions_no_selected').addClass('box_sessions_selected')

                    //reset duration
                    jQuery('.box_duration').removeClass('box_sessions_selected').addClass('box_sessions_no_selected')
                });

            jQuery(".dropdown_sessions").change(function (event) {

                var valSelected = jQuery(this).val()

                updateDurationOfSessionsStatusFromNumberOfSessionsSelected(jQuery(this).val())

                jQuery('.box_sessions').removeClass('box_sessions_selected').addClass('box_sessions_no_selected')

                jQuery('.box_session_custom').removeClass('box_sessions_selected').addClass('box_sessions_no_selected');


                if (valSelected != '') {

                    jQuery('.box_session_custom').removeClass('box_sessions_no_selected').addClass('box_sessions_selected')

                    //reset duration
                    jQuery('.box_duration').removeClass('box_sessions_selected').addClass('box_sessions_no_selected')
                    jQuery('#duration_session').val('')
                }

            });

            function updateDurationOfSessionsStatusFromNumberOfSessionsSelected(numOfSessionsSelected) {

                //clean disabled
                jQuery('.box_duration').removeClass('div-disabled')

                //check each duration of session box
                refreshUserCanSelectedDurationOfSessions(numOfSessionsSelected, 15)
                refreshUserCanSelectedDurationOfSessions(numOfSessionsSelected, 30)
                refreshUserCanSelectedDurationOfSessions(numOfSessionsSelected, 45)

                jQuery('#number_session').val(numOfSessionsSelected)
                jQuery('#duration_session').val('')
            }

            /*
                @var numSessions: 15, 30, 45
                @var boxSession
            */
            function refreshUserCanSelectedDurationOfSessions(numOfSessionsSelected, durationOfSession) {

                var sessionTypeIdSelected = jQuery('input:radio[name=session_type_id]:checked').val()

                var isDurationEnabled = false;

                if (sessionTypeIdSelected in setupAvailability) {

                    if (durationOfSession in setupAvailability[sessionTypeIdSelected]) {

                        if (numOfSessionsSelected in setupAvailability[sessionTypeIdSelected][durationOfSession]) {
                            isDurationEnabled = true;
                        }
                    }
                }

                if (!isDurationEnabled) {
                    jQuery('.box_duration_' + durationOfSession).addClass('div-disabled')
                }
            }

            /*****************************
             /** duration sessions logic **
             /*****************************/
            jQuery(document).on('click', '.box_duration', function (e) {

                e.preventDefault();

                var isDisabled = jQuery(this).hasClass('div-disabled')

                if (isDisabled) {
                    return;
                }


                jQuery('#duration_session').val('')

                var numSessions = jQuery(this).data('duration-sessions');
                jQuery('#duration_session').val(numSessions)


                jQuery('.box_duration').removeClass('box_sessions_selected').addClass('box_sessions_no_selected')

                jQuery(this).removeClass('box_sessions_no_selected').addClass('box_sessions_selected')
            });


            /*****************************
             /** language **
             /*****************************/
            jQuery("#language_id").change(function (event) {

                var isLanguageLingro = jQuery(this).find(':selected').data('is-lingro')

                //reset
                jQuery('#user_lingro').val('')
                jQuery('#div_lingro_user').removeClass('d-block').addClass('d-none')

                jQuery('#guide_id').val('')
                jQuery('#div_guide').removeClass('d-block').addClass('d-none')

                if (isLanguageLingro) {
                    jQuery('#div_lingro_user').removeClass('d-none').addClass('d-block')
                }
            });

            jQuery("#user_lingro").change(function (event) {

                jQuery('#guide_id').val('')
                jQuery('#guide_id').empty();
                jQuery('#div_guide').removeClass('d-block').addClass('d-none')

                var isUserLingro = jQuery(this).val()

                if (isUserLingro == 1) {

                    if (jQuery(this).val() == '') {
                        return false;
                    }

                    jQuery('#div_guide').removeClass('d-none').addClass('d-block')

                    //config guides
                    var originId = 2 //2 = id lingrolearning model GuideOrigin
                    var languageId = jQuery('#language_id').val();
                    var loadUrl = '/admin/api/options/guide/language/' + originId + '/' + languageId;

                    jQuery.get(loadUrl, function (data) {

                        var model = jQuery('#guide_id');
                        model.empty();

                        jQuery.each(data.items, function (index, element) {
                            var option = jQuery('<option value="' + element.id + '">' + element.name + '</option>');
                            model.append(option);
                        });
                    }, 'json');
                }
            });
        });
    </script>

@endsection

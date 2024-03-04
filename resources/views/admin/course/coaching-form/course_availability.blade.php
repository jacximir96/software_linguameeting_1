<div class="col-12 ">
    <span class="title-field-form "><i class="fa fa-clipboard-list fa-fw"></i> Number of Sessions</span>

    <div class="card  border-0">
        <div class="card-body p-0">
            <div class="row background-field {{ $errors->has('number_session') ? ' div-invalid ' : ''}}" id="div_number_session">

                <div class="col-md-4 cursor_pointer">
                    <div class="border bg-white rounded box_sessions box_session_6 box_course_information_option {{$form->isSessionsNumberSelected(6) ? 'box_sessions_selected' : ''}} p-3"
                         id="box_sessions_6"
                         data-active="0"
                         data-num-sessions="6">

                        <span class="label d-block text-center box_sessions_number">6</span>
                        <span class="description d-block text-center box_sessions_tag">Sessions</span>
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 cursor_pointer">
                    <div class="border bg-white rounded box_sessions box_session_12 box_course_information_option {{$form->isSessionsNumberSelected(12) ? 'box_sessions_selected' : ''}} p-3"
                         id="box_sessions_12"
                         data-active="0"
                         data-num-sessions="12">

                        <span class="label d-block text-center box_sessions_number">12</span>
                        <span class="description d-block text-center box_sessions_tag">Sessions</span>
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 ">
                    <div class="border bg-white d-flex align-items-center flex-direction-column rounded box_course_information_option box_session_custom {{$form->isSessionsDropdownSelected(12) ? 'box_sessions_selected' : ''}} " id="boxCustom">
                        {{Form::select('sessions_dropdown', $optionsCustomSessions,null, [
                            'placeholder' => 'Custom',
                            'style' => 'width:90% !important;',
                            'class' => 'dropdown_sessions form-select form-control mt-4 mb-4 mb-md-0'])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Form::hidden('number_session', null, ['id' => 'number_session', 'class' => 'd-none'])}}


<div class="col-12 mt-4">
    <span class="title-field-form "><i class="fa fa-clock fa-fw"></i> Duration of Sessions</span>

    <div class="card   border-0">
        <div class="card-body p-0">
            <div class="row background-field {{ $errors->has('duration_session') ? ' div-invalid ' : ''}}">

                <div class="col-md-4">

                    <div class="border bg-white box_duration box_duration_15 box_course_information_option p-3
                                {{$form->isSessionsDurationDisabled(15) ? 'div-disabled' : ''}}
                                {{$form->isSessionsDurationSelected(15) ? 'box_sessions_selected' : ''}}
                                " id="box_duration_15" data-duration-sessions="15">

                        <span class="label d-block text-center box_sessions_number">15</span>
                        <span class="description d-block text-center box_sessions_tag">Minutes</span>
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 ">
                    <div class="border bg-white box_duration box_duration_30 box_course_information_option p-3
                                {{$form->isSessionsDurationDisabled(30) ? 'div-disabled' : ''}}
                                {{$form->isSessionsDurationSelected(30) ? 'box_sessions_selected' : ''}}
                                " id="box_duration_30" data-duration-sessions="30">

                        <span class="label d-block text-center box_sessions_number">30</span>
                        <span class="description d-block text-center box_sessions_tag">Minutes</span>
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 ">
                    <div class="border bg-white box_duration box_duration_45 box_course_information_option p-3

                        {{$form->isSessionsDurationDisabled(45) ? 'div-disabled' : ''}}
                        {{$form->isSessionsDurationSelected(45) ? 'box_sessions_selected' : ''}}
                        " id="box_duration_45" data-duration-sessions="45">

                        <span class="label d-block text-center box_sessions_number">45</span>
                        <span class="description d-block text-center box_sessions_tag">Minutes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Form::hidden('duration_session', null, ['id' => 'duration_session', 'class' => 'd-none'])}}

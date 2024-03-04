@extends('layouts.app_modal')

@section('content')

    <div class="row mt-0">
        <div class="col-12">
            <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold">
                <i class="fa fa-user"></i> {{$enrollmentSession->enrollment->user->writeFullName()}}
            </span>
        </div>
    </div>

    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'session-feedback-form',
           'files' => true,
           ]) }}


            <div class="row">
                <div class="col-sm-5">

                    <div class="row mt-3">
                        <div class="mb-2 col-12 text-600">
                            <span class="fw-bold mb-2">Session Attendance</span>
                        </div>
                        <div class="col-sm-6">
                            {{Form::radio('is_attended', 1, null, ['id' => 'is_attended', 'class'=>'attended'])}} Attended
                        </div>

                        <div class="col-sm-6">
                            {{Form::radio('is_attended',0, null, ['id' => 'is_attended', 'class'=>'attended'])}} Missed
                        </div>

                        @error('is_attended')
                        <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 ">
                            @include('common.form-field.select', [  'field' => 'prepared_class_type_id',
                                                                    'label' => 'Preparation for class',
                                                                    'optionsField' => 'preparedClassTypeOptions',
                                                                    'placeholder' => 'Select prepared for class'])
                        </div>
                    </div>


                    <div class="row mt-3">

                        <div class="col-12 ">
                            @include('common.form-field.select', [  'field' => 'puntuality_type_id',
                                                                    'label' => 'Puntuality',
                                                                    'optionsField' => 'puntualityTypeOptions',
                                                                    'placeholder' => 'Select Puntuality'])
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            @include('common.form-field.select', [  'field' => 'participation_type_id',
                                                                    'label' => 'Participation',
                                                                    'optionsField' => 'participationTypeOptions',
                                                                    'placeholder' => 'Select Participation'])
                        </div>
                    </div>
                </div>

                <div class="col-sm-7">

                    <div class="row mt-3">
                        <div class="col-12">
                            @include('common.form-field.textarea', ['field' => 'observations',
                                                                    'label' => 'Observations',
                                                                    'id' => 'ckeditor',
                                                                    'rows' => 7,
                                                                    'ckEditor' => 'ckeditor-basic'])
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-end">
                    <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                        Save
                    </button>
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>

@endsection

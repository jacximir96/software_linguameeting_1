@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex justify-content-between bg-text-corporate-color text-white">
            <span class="">
                <i class="fas fa-edit me-1"></i>
                @if ($form->isCreate())
                    Create new request
                @else
                    Information about the university
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="sbp-preview">
                <div class="sbp-preview-content">

                    @include('common.form_message_errors')

                    {{ Form::model($form->model(),  [
                   'class' => '',
                   'url'=> $form->action(),
                   'autocomplete' => 'off',
                   'id' =>'request-form'
                   ]) }}

                    <div class="row">
                        <div class="mb-3 col-md-3">
                            @include('common.form-field.select', [  'field' => 'university_id',
                                                                    'label' => 'University',
                                                                    'optionsField' => 'universitiesOptions',
                                                                    'placeholder' => 'Select University'])
                        </div>
                        <div class="mb-3 col-md-2">
                            @include('common.form-field.number', ['field' => 'number_codes', 'label' => 'Number of codes', 'min' => 1])
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            @include('common.form-field.select', [  'field' => 'course_type_id',
                                                                    'label' => 'Linguameeting codes',
                                                                    'id' => 'without-experiences',
                                                                    'customClass' => 'dropdown-type',
                                                                    'optionsField' => 'courseTypeOptions',
                                                                    'placeholder' => 'Select Course type'])
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            @include('common.form-field.select', [  'field' => 'experience_course_type_id',
                                                                    'label' => 'Linguameeting codes + Experiences ',
                                                                    'id' => 'with-experiences',
                                                                    'customClass' => 'dropdown-type',
                                                                    'optionsField' => 'experiencesCourseTypeOptions',
                                                                    'placeholder' => 'Select Course type + experiences'])
                        </div>
                    </div>

                    <div class="row">

                    </div>

                    <div class="row">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                {{$form->isCreate() ? 'Create' : 'Update'}}
                            </button>
                        </div>
                    </div>

                    {{Form::close()}}
                </div>

            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery.ajaxSetup({cache: false});

            jQuery(document).on('change', '.dropdown-type', function (event){

                if ($(this).attr('id') == 'without-experiences'){
                    $("#with-experiences option").prop("selected", function () {
                        return this.defaultSelected;
                    });
                }
                else{
                    $("#without-experiences option").prop("selected", function () {
                        return this.defaultSelected;
                    });
                }
            });
        });
    </script>

@endsection

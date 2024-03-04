@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'course-basic-form'
   ]) }}

        <div class="row mt-3">
            <div class="col-12">
                @include('common.form-field.select', [  'field' => 'level_id',
                                                         'label' => 'Level',
                                                         'optionsField' => 'levelOptions',
                                                         'placeholder' => 'Select Level',
                                                         'normalText' => true])
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-12 col-sm-6">
                @include('common.form-field.number', ['field' => 'student_class', 'label' => 'Students per session', 'min' => 1, 'required' => true, 'normalText' => true])
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

@endsection

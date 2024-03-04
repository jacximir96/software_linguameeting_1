@extends('layouts.app_modal')

@section('content')



    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'university-instructor-form'
   ]) }}

    <div class="row mt-3">

        <div class="co-12">
            @include('common.form-field.select', [  'field' => 'university_id',
                                                     'label' => 'University',
                                                     'optionsField' => 'universityOptions',
                                                     'placeholder' => 'Select University'])
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-12 text-left">
            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                Assign
            </button>
        </div>
    </div>
    {{Form::close()}}

@endsection

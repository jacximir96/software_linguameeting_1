@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'assign-make-up-form'
   ]) }}

    <div class="row mt-2">
        <div class="col-12">
            Add purchase make-up to course: <span class="fw-bold fst-italic font-primary">{{$course->name}}</span>
        </div>
    </div>

        <div class="row mt-3">
            <div class="col-6 ">
                @include('common.form-field.number', ['field' => 'number_makeups', 'label' => 'Make-ups Numbers', 'min' => 1, 'step' => 1, 'required' => true])
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

@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'make-up-form'
   ]) }}


        <div class="row mt-3">
            <div class="col-12">
                @include('common.form-field.select', [  'field' => 'number_makeups',
                                                             'label' => 'Make-up Sessions',
                                                             'optionsField' => 'makeUpsSessionsOptions',
                                                             'placeholder' => 'Select Option',
                                                             'normalText' => true])
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

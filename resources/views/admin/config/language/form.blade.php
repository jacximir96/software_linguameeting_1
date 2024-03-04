@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'language-form',
   ]) }}

        <div class="row mt-3">
            <div class="col-12 col-sm-6">
                @include('common.form-field.text', ['field' => 'name', 'label' => 'Name', 'min' => 1])
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-sm-6 col-xl-3 mt-3">
                <span class="title-field-form "> Is Lingro?</span>
                <input type="hidden" name="is_lingro" value="0"/>
                {{Form::checkbox('is_lingro', 1, null, ['class' => 'form-check-input d-block'])}}
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

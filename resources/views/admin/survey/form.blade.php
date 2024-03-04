@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'survey-form',
   ]) }}

        <div class="row mt-3">
            <div class="col-12">
                @include('common.form-field.text', ['field' => 'description', 'label' => 'Description'])
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                @include('common.form-field.url', ['field' => 'url', 'label' => 'Url'])
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <label class=" mb-1 d-block fw-bold" for="flexCheckDefault">Active</label>
                <input type="hidden" name="active" value="0"/>
                {{Form::checkbox('active', 1, null, ['class' => 'form-check-input'])}}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 mt-2 ">
                @include('common.form-field.textarea', ['field' => 'observations',
                                                                        'label' => 'Observations',
                                                                        'id' => 'ckeditor',
                                                                        'rows' => 5,
                                                                        'ckEditor' => 'ckeditor-basic'])
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

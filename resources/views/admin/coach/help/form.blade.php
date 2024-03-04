@extends('layouts.app_modal')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'coach-help-form',
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row">
                        <div class="col-sm-4 col-xl-2">
                            @include('common.form-field.select', [  'field' => 'coach_help_type_id',
                                                                    'label' => 'Type',
                                                                    'optionsField' => 'typeOptions',
                                                                    'placeholder' => 'Select Type'])
                        </div>

                    </div>

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

                    <div class="row mt-5">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                {{$form->isCreate() ? 'Create' : 'Update'}}
                            </button>
                        </div>
                    </div>


                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
@endsection

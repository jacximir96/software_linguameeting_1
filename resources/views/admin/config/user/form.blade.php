@extends('layouts.app')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'chat-jira-form',
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row mt-3">
                        <div class="col-xl-6">

                            @include('common.form-field.checkbox', [
                                        'description' => 'Checking this box, new users will have to validate their email to validate their account.',
                                        'field' => 'check_email_exist',
                                        'value' => true,
                                        'label' => 'Check new email exist?',
                                        'boldLabel' => true ])

                        </div>
                    </div>



                    <div class="row mt-5">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
@endsection

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
                        <div class="col-xl-3">
                            <div class="row mt-3">
                                <div class="mb-3 col-6">
                                    @include('common.form-field.checkbox', ['field' => 'enable_chat', 'value' => true, 'label' => 'Enable Chat', 'boldLabel' => true ])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-sm-4 col-xl-2">
                            @include('common.form-field.time', ['field' => 'start_chat_at', 'label' => 'Start'])
                        </div>

                        <div class="col-sm-4 col-xl-2">
                            @include('common.form-field.time', ['field' => 'end_chat_at', 'label' => 'End'])
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

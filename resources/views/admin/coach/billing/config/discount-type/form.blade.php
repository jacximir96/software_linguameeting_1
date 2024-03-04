@extends('layouts.app_modal')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'discount-type-form',
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row mt-3">
                        <div class="col-12">
                            @include('common.form-field.text', ['field' => 'name', 'label' => 'Name'])
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.textarea', ['field' => 'description', 'label' => 'Description', 'rows' => 3])
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

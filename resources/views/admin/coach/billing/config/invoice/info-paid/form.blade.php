@extends('layouts.app')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'incentive-type-form',
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.textarea', ['field' => 'paid_info', 'label' => 'Paid Info', 'ckEditor' => 'ckeditor-basic'])
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

@extends('layouts.app')

@section('content')


    <div class="card mb-4 col-8">
        <div class="card-header p-2 d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-book me-1"></i>
                Edit Conversation Package
            </span>
        </div>
        <div class="card-body ">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'conversation-package-form',
           ]) }}

            <div class="row mt-3">
                <div class="col-xl-3">
                    <div class="row mt-3">
                        <div class="mb-3 col-6">
                            @include('common.form-field.checkbox', ['field' => 'code_active', 'value' => true, 'label' => 'Active', 'boldLabel' => true ])
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.checkbox', ['field' => 'experiences', 'value' => true, 'label' => 'Experiences' , 'boldLabel' => true])
                        </div>
                    </div>
                </div>
            </div>





            <div class="row mt-2">
                <div class="col-12 col-xl-4">
                    @include('common.form-field.select', [  'field' => 'session_type_id',
                                                                 'label' => 'Session Type',
                                                                 'optionsField' => 'sessionTypeOptions',
                                                                 'placeholder' => 'Select Type',
                                                                 ])
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-12 col-xl-6">
                    @include('common.form-field.text', ['field' => 'name', 'label' => 'Name', 'min' => 1])
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-xl-3">
                    <div class="row mt-3">
                        <div class="col-12">
                            @include('common.form-field.number', ['field' => 'number_session', 'label' => 'Number Sessions', 'min' => 1, 'step' => 1])
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="row mt-3">
                        <div class="col-12">
                            @include('common.form-field.number', ['field' => 'duration_session', 'label' => 'Duration Sessions', 'min' => 15, 'step' => 15, 'max' => 45])
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-12 col-xl-6">
                    @include('common.form-field.text', ['field' => 'isbn', 'label' => 'ISBN'])
                </div>
            </div>

            <div class="form-group row mt-3">
                <div class="col-12 text-600">
                    <span class="fw-bold  mb-2  @error('price') text-danger-disabled.. @enderror ">Price</span>
                </div>
                <div class="col-12 col-xl-2">
                    {{Form::number('price', null, ['class' => 'form-control ', 'min' => 0, 'step' => '0.01'])}}

                    @error('price')
                    <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                    <span class="custom-invalid-feedback d-none" id="feedback-error-{{'price'}}" role="alert">
                <strong></strong>
            </span>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-xl-6">
                    @include('common.form-field.textarea', ['field' => 'comments', 'label' => 'Comments', 'rows' => 3])
                </div>

            </div>


            <div class="row mt-3">
                <div class="col-12 col-xl-6 text-end">
                    <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                        Save
                    </button>
                </div>
            </div>
            {{Form::close()}}

        </div>

    </div>

@endsection

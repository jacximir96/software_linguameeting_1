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

                    <div class="col-4 col-md-3">
                        <label class="small mb-1 fw-bold @error('salary_type_id') text-danger @enderror" for="university_id">Type</label>
                        <div class="form-group row">
                            <div class="col-12">
                                {{Form::select('salary_type_id', $form->optionsField('salaryTypeOptions'), null,
                                [   'class'=>'form-control form-select',
                                    'placeholder' => 'Select Type',
                                    'id' => 'salary_type_id',
                                    ])}}
                                @error('salary_type_id')
                                <span class="custom-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-4">
                            @include('common.form-field.number', ['field' => 'value', 'label' => 'Salary', 'min' => 0, 'step' => '0.01'])
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-4">
                            @include('common.form-field.number', ['field' => 'extra_coordinator', 'label' => 'Extra salary as coordinator', 'min' => 0, 'step' => '0.01'])
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.checkbox', ['field' => 'is_payer', 'value' => 'is_payer', 'label' => 'Is Payer', 'boldLabel' => true ])

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.textarea', ['field' => 'comments', 'label' => 'Comments', 'ckEditor' => 'ckeditor-basic', 'rows' => 3])
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

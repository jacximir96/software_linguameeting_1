@extends('layouts.app')

@section('content')

    <div class="card my-3">
        <div class="card-header d-flex justify-content-between bg-text-corporate-color text-white">
            <span class="">
                <i class="fas fa-edit me-1"></i>
                @if ($form->isCreate())
                    Create University
                @else
                    Edit University
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="sbp-preview">
                <div class="sbp-preview-content">

                    @include('common.form_message_errors')

                    {{ Form::model($form->model(),  [
                   'class' => '',
                   'url'=> $form->action(),
                   'autocomplete' => 'off',
                   'id' =>'university-form'
                   ]) }}
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            @include('common.form-field.text', ['field' => 'name', 'label' => 'Name'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            @include('common.form-field.select', [  'field' => 'university_level_id',
                                                                    'label' => 'Level',
                                                                    'optionsField' => 'levelOptions',
                                                                    'placeholder' => 'Select Level'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            @include('common.form-field.select', [  'field' => 'country_id',
                                                                    'label' => 'Country',
                                                                    'optionsField' => 'countryOptions',
                                                                    'placeholder' => 'Select Country'])
                        </div>
                        <div class="mb-3 col-md-3">
                            @include('common.form-field.select', [  'field' => 'timezone_id',
                                                                    'label' => 'Time Zone',
                                                                    'optionsField' => 'timezoneOptions',
                                                                    'placeholder' => 'Select Time Zone'])
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            @include('common.form-field.textarea', ['field' => 'internal_comment', 'label' => 'Comment', 'rows' => 3])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                {{$form->isCreate() ? 'Create' : 'Update'}}
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>

            </div>
        </div>
    </div>

@endsection

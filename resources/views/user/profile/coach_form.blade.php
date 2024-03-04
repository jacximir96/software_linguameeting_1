@extends('layouts.app')

@section('content')

    <div class="card my-3">
        <div class="card-header d-flex justify-content-between bg-text-corporate-color text-white">
            <span class="">
                <i class="fas fa-edit me-1"></i>
                My profile
            </span>
        </div>
        <div class="card-body container">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'profile-form',
           'files' => true,
           ]) }}

            <div class="row mt-1">
                <div class="col-12 border-bottom">
                    <span class=" fw-bold  fst-italic text-corporate-color">Personal info</span>
                </div>
            </div>

            @include('user.profile.fields.personal_info', ['withWhereDoYouLive' => true])


            <div class="row mt-3">

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    @include('common.form-field.select', [  'field' => 'timezone_id',
                                                            'label' => 'Select your Time Zone',
                                                            'optionsField' => 'timezoneOptions',
                                                            'placeholder' => 'Select Time Zone'])
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    @include('common.form-field.select', [  'field' => 'language_id',
                                                            'label' => 'Language',
                                                            'optionsField' => 'languageOptions',
                                                            'placeholder' => 'Select Language'])
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 border-bottom">
                    <span class=" fw-bold  fst-italic text-corporate-color">Contact Info</span>
                </div>
            </div>

            @include('user.profile.fields.contact', ['withZoom' => true])

            <div class="row mt-5">
                <div class="col-12 border-bottom">
                    <span class=" fw-bold  fst-italic text-corporate-color">What are you like?</span>
                </div>
            </div>

            @include('user.profile.coach.description')

            <div class="row mt-5">
                <div class="col-12 border-bottom">
                    <span class=" fw-bold  fst-italic text-corporate-color">Security</span>
                </div>
            </div>

            @include('user.profile.fields.password')

            <div class="row mt-5">
                <div class="col-12 border-bottom">
                    <span class=" fw-bold  fst-italic text-corporate-color">Preferences</span>
                </div>
            </div>

            @include('user.profile.fields.preference')

            <div class="row mt-5">
                <div class="col-12 text-left">
                    <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                        Update
                    </button>
                </div>
            </div>
            {{Form::close()}}
        </div>


    </div>

@endsection

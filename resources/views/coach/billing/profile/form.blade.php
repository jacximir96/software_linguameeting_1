@extends('layouts.app')

@section('content')

    <div class="container">

        @include('common.form_message_errors')

        {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'coach-billing-profile-form',

       ]) }}

        <div class="row mt-1">
            <div class="col-12 border-bottom">
                <span class=" fw-bold  fst-italic text-corporate-color">Personal info</span>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-sm-6 col-lg-4 col-xl-3">

                <div class="form-group row">
                    <div class="col-12 text-600">
                        <span class="fw-bold d-block">Full Name</span>
                    </div>
                    <div class="col-12">
                        {{Form::text('full_name', null, [
                                'id' => '',
                                'class' => 'form-input-full_name form-control ' .($errors->has('full_name') ? ' is-invalid ' : null),

                        ])}}
                        <span class="d-block text-muted small">Type your name as it is listed in your bank or id/passport</span>
                        @error('full_name')
                            <span class="custom-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'ind', 'label' => 'Identity National Document'])
            </div>

        </div>

        <div class="row mt-2">
            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'address', 'label' => 'Address'])
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-2">
                @include('common.form-field.text', ['field' => 'postal_code', 'label' => 'Postal Code'])
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'city', 'label' => 'City'])
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.select', [  'field' => 'country_id',
                                                        'label' => 'Country',
                                                        'optionsField' => 'countryOptions',
                                                        'placeholder' => 'Select Country'])
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 border-bottom">
                <span class=" fw-bold  fst-italic text-corporate-color">Bank Info</span>
            </div>
        </div>

        <div class="row mt-2">

        </div>

        <div class="row mt-2">
            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'bank_name', 'label' => 'Bank Name'])
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'bank_account', 'label' => 'Bank Account'])
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'swift', 'label' => 'Swift'])
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.text', ['field' => 'route_number', 'label' => 'Route Number'])
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.select', [  'field' => 'account_type_id',
                                                        'label' => 'Account Type',
                                                        'optionsField' => 'accountTypeOptions',
                                                        'placeholder' => 'Select Account Type'])
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12 col-xl-6">
                @include('common.form-field.textarea', ['field' => 'bank_observations',
                                                                    'label' => 'Bank Observations',
                                                                    'id' => 'ckeditor',
                                                                    'rows' => 5,
                                                                    'ckEditor' => 'ckeditor-basic'])
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 border-bottom">
                <span class=" fw-bold  fst-italic text-corporate-color">Payment Info</span>
            </div>
        </div>

        <div class="row mt-3">

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.select', [  'field' => 'method_payment_id',
                                                        'label' => 'Method Payment',
                                                        'optionsField' => 'paymentsOptions',
                                                        'placeholder' => 'Select Payment Option'])
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.select', [  'field' => 'currency_id',
                                                        'label' => 'Currency',
                                                        'optionsField' => 'currenciesOptions',
                                                        'placeholder' => 'Select Currency'])
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('common.form-field.email', ['field' => 'paypal_email', 'label' => 'Paypal Email'])
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12 col-xl-6">
                @include('common.form-field.textarea', ['field' => 'paid_info',
                                                                    'label' => 'Paid Info',
                                                                    'class' => 'ckeditor',
                                                                    'rows' => 7,
                                                                    'style' => "font-size:12px",
                                                                    'ckEditor' => 'ckeditor-basica'])
                <p>

                </p>
                <span class="d-block text-muted">Indica tus datos que aparecerán en la cabecera de tus facturas.</span>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-left">
                <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                    Update
                </button>
            </div>
        </div>
        {{Form::close()}}
    </div>

@endsection

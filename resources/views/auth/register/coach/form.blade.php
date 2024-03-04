<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>


    {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'form-personal-data'
               ]) }}
        <div class="container mt-5" style="background-color: #F7F7F7;">

            <div class="row">

                <div class="col-xl-6 offset-xl-3 mb-5">


                    <div class="row mt-3">
                        <div class="col-12">
                            @include('flash::message')
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <h4 class="colorBase2">Coach Register</h4>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">

                            <span class="d-block font-weight-bold">Instructions</span>

                            <span class="d-block mt-3 colorBase1 pl-2">1. Fill out required fields.</span>

                            <span class="d-block mt-3 colorBase1 pl-2">2. Once completed, check your email to activate your account.</span>

                            <span class="d-block mt-3 colorBase1 pl-2">3. Once activated, you may log into your account.</span>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <span class="d-block font-weight-bold">Fields to Fill</span>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            @include('common.form_message_errors')
                        </div>
                    </div>

                    <div class="row mt-2">

                        <div class="col-12">
                            <label for="name" class="col-form-label label-field-register-student text-md-end" style="">First Name</label>
                            {{Form::text('name', null, [
                                    'id' => 'name',
                                    'required' => true,
                                    'class' => 'form-control form-control-sm ' .($errors->has('name') ? ' is-invalid ' : null),

                            ])}}
                            @error('name')
                            <span class="invalid-feedback" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">

                        <div class="col-12">
                            <label for="lastname" class="col-form-label label-field-register-student text-md-end">Last Name</label>
                            {{Form::text('lastname', null, [
                                    'id' => 'lastname',
                                    'required' => true,
                                    'class' => 'form-control  form-control-sm ' .($errors->has('lastname') ? ' is-invalid ' : null),

                            ])}}
                            @error('lastname')
                            <span class="invalid-feedback" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">

                        <div class="col-12">
                            <label for="email" class="col-form-label label-field-register-student text-md-end">Email Address</label>
                            {{Form::email('email', null, [
                                    'id' => 'email',
                                    'required' => true,
                                    'class' => 'form-control  form-control-sm ' .($errors->has('email') ? ' is-invalid ' : null),

                            ])}}
                            @error('email')
                            <span class="invalid-feedback" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">

                        <div class="col-12">
                            <label for="password" class="col-form-label label-field-register-student text-md-end">Password</label>
                            {{Form::text('password', null, [
                                    'id' => 'password',
                                    'required' => true,
                                    'class' => 'form-control  form-control-sm ' .($errors->has('password') ? ' is-invalid ' : null),

                            ])}}
                            @error('last_name')
                            <span class="invalid-feedback" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <a href="{{route('get.public.password.generate')}}" class="fst-italic small d-inline-block mr-5" id="generate_password">Generate</a>

                            <a href="#" class="text-primary show-hide-password small d-inline-block" id="basic-addon1">
                                Hide
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-12">
                            <label for="password_confirmation" class="col-form-label label-field-register-student text-md-end">Password Confirmation</label>
                            {{Form::text('password_confirmation', null, [
                                    'id' => 'password_confirmation',
                                    'required' => true,
                                    'class' => 'form-control form-control-sm ' .($errors->has('password_confirmation') ? ' is-invalid ' : null),

                            ])}}
                            @error('password_confirmation')
                            <span class="invalid-feedback" >
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-muted small">
                            <span class="text-muted d-block">Your password must contain the following:</span>
                            <div class="ms-4">
                                <ul style=" list-style-position: inside; padding-left: 10px; ">
                                    <li >At length of at least six characters.</li>
                                    <li >At least one lowercase character.</li>
                                    <li >At least one uppercase character.</li>
                                    <li >At least one number.</li>
                                    <li >At least one special character: @ # $ % &amp; + ! = ?</li>
                                </ul>
                            </div>


                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="country_id" class="col-form-label label-field-register-student text-md-end">Where are you from?</label>

                            {{Form::select('country_id', $form->optionsField('countryOptions'), null,
                               [   'class'=>'form-input-country-id form-control form-select form-control-xl' .($errors->has('country_id') ? ' is-invalid ' : null),
                                   'id' => 'country-id',
                                   'required' => true,
                                   'placeholder' => 'Select',
                                   ])}}

                            @error('country_id')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="timezone_id" class="col-form-label label-field-register-student text-md-end">Select your Time Zone</label>

                            {{Form::select('timezone_id', $form->optionsField('timezoneOptions'), null,
                               [   'class'=>'form-input-timezone_id form-control form-select form-control-xl' .($errors->has('timezone_id') ? ' is-invalid ' : null),
                                   'id' => 'country-id',
                                   'required' => true,
                                   'placeholder' => 'Select',
                                   ])}}

                            @error('timezone_id')
                            <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mt-2">

                        <div class="col-12">
                            <label for="email" class="col-form-label label-field-register-student text-md-end">
                                If you have a Zoom account, please put the associated email address below.
                            </label>
                            {{Form::email('zoom_email', null, [
                                    'id' => 'zoom-email',
                                    'placeholder' => 'Zoom Email',
                                    'class' => 'form-control  form-control-sm ' .($errors->has('zoom_email') ? ' is-invalid ' : null),

                            ])}}
                            @error('zoom_email')
                            <span class="invalid-feedback" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label for="email" class="col-form-label label-field-register-student text-md-end">
                                If you do not have an account, LinguaMeeting will create an account for you using your LinguaMeeting email.
                                You may change this later from the "My profile" tab in your portal.
                            </label>
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col-12">
                            <label for="language_id" class="col-form-label label-field-register-student text-md-end">Language</label>

                            {{Form::select('language_id', $form->optionsField('languageOptions'), null,
                               [   'class'=>'form-input-timezone_id form-control form-select form-control-xl' .($errors->has('language_id') ? ' is-invalid ' : null),
                                   'id' => 'language-id',
                                   'required' => true,
                                   'placeholder' => 'Select',
                                   ])}}

                            @error('language_id')
                            <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 margin-top10">
                            <button type="submit" id="submit-button" class="btn backgroundColor35b4b4 colorWhite float-left w-100 font-weight-bold">
                                <span class="">Register</span>&nbsp;&nbsp;
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    {{Form::close()}}

</main>

@include('common.web.footer')

</body>
</html>

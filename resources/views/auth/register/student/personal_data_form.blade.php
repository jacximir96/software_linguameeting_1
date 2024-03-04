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

        <div class="row mt-3">
            <div class="col-12">
                @include('flash::message')
            </div>
        </div>

        <div class="row f-flex">

            <div class="col-xl-6 flex-fill pb-5" >

                @include('common.form_message_errors')

                <div class="row">

                    <div class="col-12">
                        <label for="first_name" class="col-form-label  label-field-register-student text-md-end" style="">First Name</label>
                        {{Form::text('first_name', null, [
                                'id' => 'first_name',
                                'required' => true,
                                'class' => 'form-control form-control-sm ' .($errors->has('first_name') ? ' is-invalid ' : null),

                        ])}}
                        @error('first_name')
                        <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">

                    <div class="col-12">
                        <label for="last_name" class="col-form-label label-field-register-student text-md-end">Last Name</label>
                        {{Form::text('last_name', null, [
                                'id' => 'last_name',
                                'required' => true,
                                'class' => 'form-control  form-control-sm ' .($errors->has('last_name') ? ' is-invalid ' : null),

                        ])}}
                        @error('last_name')
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
                        <label for="email_confirmation" class="col-form-label label-field-register-student text-md-end">Confirm Email Address</label>
                        {{Form::email('email_confirmation', null, [
                                'id' => 'email_confirmation',
                                'required' => true,
                                'class' => 'form-control form-control-sm ' .($errors->has('email_confirmation') ? ' is-invalid ' : null),

                        ])}}
                        @error('email_confirmation')
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
                        @error('password')
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

                <div class="row mt-2">

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

                <div class="row">

                    <div class="col-12 d-flex justify-content-end">
                        <div class="form-group margin-top20">
                            <div class="float-left padding-right10 margin-top2">
                                <input name="check_terms" id="check_terms" type="checkbox"  class="{{$errors->has('check_terms') ? ' is-invalid ' : null}}">
                                @error('check_terms')
                                <span class="invalid-feedback" >
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="check_terms" class="">I've read and agree with the
                                <u> <a href="../terms" target="_blank" class="color4">Terms and Conditions</a></u>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 flex-fill pb-5" >
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="colorBase2">{{$section->course->name}}</h3>
                    </div>
                </div>

                @if ($section->instructor)
                    <div class="row mt-2">
                        <div class="col-12 text-center">
                            <h4 class="colorBase2">
                                Prof. {{$section->instructor->writeFullName()}}
                            </h4>
                        </div>
                    </div>
                @endif

                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <h4 class=" colorBase1">{{$section->name}}</h4>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 text-center ">
                        <h6 class="colorBase1">
                            {{$section->course->semester->name}}, {{$section->course->year}}
                        </h6>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <h6 class="">
                            {{toDate($section->course->start_date)}} - {{toDate($section->course->end_date)}}
                        </h6>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-6 col-lg-4 text-center">
                        <div class="cicleSessions">{{$section->course->conversationPackage->sessionType->code}}</div>
                        <div class="circleText text-16 text_center">
                            {{$section->course->conversationPackage->sessionType->name}}
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 text-center mt-4 mt-sm-0">
                        <div class="cicleSessions">
                            {{$section->course->conversationPackage->number_session}}
                        </div>
                        <div class="circleText text-16 text_center">
                            Sessions
                        </div>
                    </div>
                    <div class="col-lg-4 text-center mt-4 mt-md-0">
                        <div class="cicleSessions">
                            {{$section->course->conversationPackage->duration_session}}
                        </div>
                        <div class="circleText text-16 text_center">
                            Minutes
                        </div>
                    </div>
                </div>

                <div class="row mt-4">

                    <div class="col-12 text-center colorBase2 h5">
                        {{$section->course->university->name}}
                    </div>
                    <div class="col-12 text-center text-deep-black ">
                        {{$section->course->university->country->name}} - {{$section->course->university->timezone->name}}
                    </div>
                </div>

                <div class="row mt-4 color4 font-weight-bold boxBlueSummary p-2 rounded" style="">
                    <div class="col-12 col-xl-6 text-center">
                        Price per student
                    </div>
                    <div class="col-12 col-xl-6 text-left" style="padding-left:10px;">
                        {{format_money($section->course->price())}}
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-12">
                        @include('auth.register.student.payment_form')
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

@extends('layouts.app_modal')

@section('content')

    <div class="container mt-0">


        <div class="row">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'experience-public-register-form',
           ]) }}
            <div class="col-12">

                <div class="row">
                    <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold">
                        Book Experience
                    </span>
                        <span class="fw-bold text-corporate-dark-color">
                        <span class="fw-bold text-decoration-underline">{{$experience->title}}</span>
                    </span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-12">
                        <label for="first_name" class="col-md-4 col-form-label text-md-end">Name</label>
                        {{Form::text('first_name', null, [
                                'id' => 'first_name',
                                'class' => 'form-control ' .($errors->has('first_name') ? ' is-invalid ' : null),

                        ])}}
                        @error('first_name')
                        <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">

                    <div class="col-12">
                        <label for="last_name" class="col-md-4 col-form-label text-md-end">Last name</label>
                        {{Form::text('last_name', null, [
                                'id' => 'last_name',
                                'class' => 'form-control ' .($errors->has('last_name') ? ' is-invalid ' : null),

                        ])}}
                        @error('last_name')
                        <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">

                    <div class="col-12">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                        {{Form::text('email', null, [
                                'id' => 'email',
                                'class' => 'form-control ' .($errors->has('email') ? ' is-invalid ' : null),

                        ])}}
                        @error('email')
                        <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">

                    <div class="col-12">
                        <label for="school" class="col-md-4 col-form-label text-md-end">School</label>
                        {{Form::text('school', null, [
                                'id' => 'school',
                                'class' => 'form-control ' .($errors->has('school') ? ' is-invalid ' : null),

                        ])}}
                        @error('school')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="col-12">

                <div class="row mt-2">

                    <div class="col-12  border p-3 rounded">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-bold text-corporate-dark-color fw-bold">Payment Option</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 ps-5">
                                <input type="radio" onclick="getbraintree()" value="brainTree" id="brainTree" class="" name="payment">
                                <span class="fw-bold" for="brainTree">Credit Card</span>

                            </div>
                            <div class="col-12 ps-5">
                                {{Form::hidden('amount', null, ['id' => 'amount'])}}
                                <input type="hidden" name="nonce" id="nonce" value="">
                                <div id="dropin-container"></div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-5 ps-5">
                                <input type="radio"
                                       name="payment"
                                       value="payEnvivoCode"
                                       id="payEnvivoCode"
                                       onclick="bookstoreCode()"
                                       class="{{$errors->has('payment') ? ' is-invalid ' : null}}">
                                <span class="fw-bold" for="payEnvivoCode">Code</span>
                            </div>

                            <div class="col-md-7 ps-5">
                                {{Form::text('code', null, [
                                    'id' => 'code',
                                    'placeholder' => 'Ex: F532-37922-8847-975',
                                    'class' => 'form-control code ' .($errors->has('code') ? ' is-invalid ' : null),
                                ])}}
                                @error('code')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>

                        @if ($errors->has('payment'))
                            <span class="invalid-feedback" style="display: block;">
                            <strong>{{ $errors->first('payment') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group margin-top20 colorBase1">
                            <label for="check_terms">Accept and Review
                                <strong> <a href="../termsExperiences" target="_blank" class="colorBase1">LinguaMeeting Community Standards </a></strong>
                            </label>
                            <div class="margin-top10">
                                <input name="check_terms" id="check_terms" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 col-sm-6 offset-sm-3 d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm btn-bold px-4 me-3" type="submit" id="submit-button">
                            Book
                        </button>

                        <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">No</button>
                    </div>
                </div>

            </div>

            {{Form::close()}}

        </div>

    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.min.js"></script>

    <script>

        function submitRegister() {
            $('#experience-public-register-form').submit()
        }

        function getbraintree() {
            $('.btn-braintree').show();
            $('.btn-bookstore').hide();
            var clientToken = "{!! $form->braintreeToken() !!}";
            var button = document.querySelector("#submit-button");
            braintree.dropin.create({
                    authorization: clientToken,
                    container: "#dropin-container",
                },
                function (createErr, instance) {
                    button.addEventListener("click", function (event) {

                        event.preventDefault()

                        instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                            $('#nonce').val(payload.nonce)

                            $('#experience-public-register-form').submit()
                        });
                    });
                });
        }

        function bookstoreCode() {
            $('.btn-braintree').hide();
            $('.btn-bookstore').show();
            $('#dropin-container').empty();
        }
    </script>

@endsection

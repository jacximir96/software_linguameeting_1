@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-12">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'register-student-experience-form',
           'files' => true,
           ]) }}

            <div class="row">
                <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold text-corporate-dark-color">
                        Register in <span class="fw-bold text-decoration-underline">{{$experience->title}}</span>
                    </span>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-12 col-sm-6 offset-sm-3  border p-3 rounded">
                    <span class="fw-bold me-2 text-corporate-dark-color fw-bold" >Price</span>
                    <span class=" fw-bold {{!$experience->isPaidPrivate() ? 'line-through' : ''}}">{{format_money($experience->price)}}</span>
                </div>

                <div class="col-12 col-sm-6 mt-4 offset-sm-3 border p-3 rounded">
                    <div class="row">
                        <div class="col-12">
                            <span class="fw-bold text-corporate-dark-color fw-bold" >Payment Option</span>
                        </div>
                    </div>

                    @if ($experience->isPaidPrivate())

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
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>

                    @if ($errors->has('payment'))
                        <span class="invalid-feedback" style="display: block;" >
                            <strong>{{ $errors->first('payment') }}</strong>
                        </span>
                    @endif

                    @else

                        <div class="row mt-3">
                            <div class="col-md-5 ps-5">
                                <input type="radio"
                                       name="payment"
                                       value="free"
                                       id="payFree" checked>
                                <span class="fw-bold" >Free</span>
                            </div>
                        </div>

                    @endif


                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12 col-sm-6 offset-sm-3 d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm btn-bold px-4 me-3" type="submit" id="submit-button">
                        Yes
                    </button>

                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">No</button>
                </div>
            </div>


            {{Form::close()}}

        </div>
    </div>


    <script src="https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.min.js"></script>

    <script>

        function submitRegister() {
            $('#register-student-experience-form').submit()
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

                            console.log(payload)

                            $('#nonce').val(payload.nonce)

                            $('#register-student-experience-form').submit()
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

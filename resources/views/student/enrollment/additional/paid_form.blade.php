@extends('layouts.app')

@section('content')

    <div class="container">


        {{ Form::model([],  [
                  'class' => '',
                  'url'=> $form->action(),
                  'autocomplete' => 'off',
                  'id' =>'additional-enrollment-form',
              ]) }}


        <div class="row mt-3 ">

            <div class="col-12 col-xl-6 border rounded p-1 d-flex justify-content-start">

                <div class="row">
                    <div class="col-12">

                        @include('common.form_message_errors')

                        <span class="d-block bg-corporate-color-light fw-bold p-1 rounded">Select your payment options</span>

                        @if ( ! $section->course->isFree())

                            <div class="row mt-4 ps-4">
                                <div class="col-12">
                                    <input type="radio" onclick="getbraintree()" value="brainTree" id="brainTree" class="" name="payment">
                                    <span class="fw-bold" for="brainTree">Credit Card</span>

                                </div>
                                <div class="col-12">
                                    {{Form::hidden('amount', null, ['id' => 'amount'])}}
                                    <input type="hidden" name="nonce" id="nonce" value="">
                                    <div id="dropin-container"></div>
                                </div>
                            </div>

                            <div class="row mt-4 ps-4">
                                <div class="col-md-5">
                                    <input type="radio"
                                           name="payment"
                                           value="payEnvivoCode"
                                           id="payEnvivoCode"
                                           onclick="bookstoreCode()"
                                           class="{{$errors->has('payment') ? ' is-invalid ' : null}}">
                                    <span class="fw-bold" for="payEnvivoCode">Bookstore Code</span>
                                </div>

                                <div class="col-md-7">
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
                                    <p class="small text-muted">* This code is purchased at the bookstore and provide you access to LinguaMeeting for one term.</p>

                                </div>
                            </div>


                            @if ($errors->has('payment'))
                                <div class="row ps-4">
                                    <div class="col-12">
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('payment') }}</strong>
                                </span>
                                    </div>
                                </div>

                            @endif

                        @else
                            <div class="row mt-4 ps-4">
                                <div class="col-12">

                                    <div class="form-group radio-item event_free_course">
                                        <input type="radio" value="payFree" id="payFree" class="" name="payment" checked>
                                        <label for="payFree"> <strong>Open Access</strong></label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mt-3 ps-4">

                            <div class="col-12 ">
                                <div class="form-group margin-top20">

                                    <input name="check_terms" id="check_terms" type="checkbox" class="{{$errors->has('check_terms') ? ' is-invalid ' : null}}">
                                    <label for="check_terms" class="ms-2">I've read and agree with the
                                        <u> <a href="../terms" target="_blank" class="color4">Terms and Conditions</a></u>
                                    </label>

                                    @error('check_terms')
                                    <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 align-self-end justify-content-end">

                        <div class="btn-braintree " style="display: none;">
                            <button type="button" id="submit-button" class="btn bg-corporate-color text-white ">
                                <span class="">Next</span>&nbsp;&nbsp;
                                <span class="btn-group-addon"><i class="fas fa-arrow-right"></i></span>
                            </button>
                        </div>

                        <div class="btn-bookstore text-end">
                            <button type="button" class="btn bg-corporate-color text-white " onclick="submitRegister()">
                                <span class="">Next</span>&nbsp;&nbsp;
                                <span class="btn-group-addon"><i class="fas fa-arrow-right"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-xl-6">
                @include('student.enrollment.additional.info_course', ['course' => $section->course])
            </div>
        </div>

        {{Form::close()}}

    </div>

@endsection

<script src="https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.min.js"></script>

<script>

    function submitRegister() {
        $('#additional-enrollment-form').submit()
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

                        $('#additional-enrollment-form').submit()
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

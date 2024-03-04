@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-12">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'experience-tip-form',
           'files' => true,
           ]) }}

            <div class="row">
                <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold text-corporate-dark-color">
                        Donation for <span class="fw-bold text-decoration-underline">{{$experience->title}}</span>
                    </span>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3 d-flex align-items-center justify-content-center">
                    <img src="{{asset('assets/img/logo_donate_web.png')}}" class="w-50"/>
                </div>
                <div class="col-9">
                    <p class="fw-bold">Make a contribution</p>
                    <p>
                    Our goal in each Experience is to simulate a trip abroad from the eyes of a local guide. In honor of this we’ve created a tip option where 100% of proceeds go
                        directly to your Experience host.
                    </p>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-sm-6 offset-sm-3">
                    <label class="fw-bold" for="amount">Amount $</label>
                    {{Form::number('amount', null, ['id' => 'amount',
                                                    'class' => 'form-control '.($errors->has('amount') ? ' is-invalid ' : null),

                                                    'min' => 0,
                                                    'step' => '0.01'])}}
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12 col-sm-6 offset-sm-3">
                    <input type="hidden" name="nonce" id="nonce" value="">
                    <div id="dropin-container"></div>
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

        function getbraintree() {
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

                            $('#experience-tip-form').submit()
                        });
                    });
                });
        }

        getbraintree();

    </script>

@endsection

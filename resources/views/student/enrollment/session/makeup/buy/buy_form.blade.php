

    <div class="row">
        <div class="col-12">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'buy-makeup-form',
           'files' => true,
           ]) }}

            <div class="row">
                <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold text-corporate-dark-color">
                        Buy Make-Ups
                    </span>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-12 col-sm-6 offset-sm-3 ">
                    <p class="mb-1 ">
                        <span class="fw-bold me-3">Price</span> <span>Each Make-Up costs <span class="border-bottom text-corporate-dark-color fw-bold" style="border-color:#000">{{format_money($costByOneMakeup)}}</span></span>
                    </p>
                </div>
            </div>

            <div class="row mt-1">

                <div class="col-12 col-sm-6 offset-sm-3 ">
                    <p class="mb-1 ">
                        <span class="fw-bold me-3">Límit</span> You have
                            <span class="border-bottom text-corporate-dark-color fw-bold" style="border-color:#000">{{$makeupAvailability->numMaxAvailableForPurchase()->get()}} Make-Ups for purchase</span>
                        </span>
                    </p>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 col-sm-6 offset-sm-3 ">
                    <label class="fw-bold" for="amount">Number of Make-Ups</label>
                    {{Form::number('number_makeups', null, ['id' => 'number_makeups',
                                                    'class' => 'form-control '.($errors->has('number_makeups') ? ' is-invalid ' : null),
                                                    'min' => 1,
                                                    'max' => $makeupAvailability->numMaxAvailableForPurchase()->get(),
                                                    'step' => '1'])}}
                    @error('number_makeups')
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

                    <button type="button" class="btn btn-sm btn-secondary px-4 close-modal" data-bs-dismiss="modal">No</button>

                    <button class="btn bg-corporate-color btn-sm btn-bold px-4 ms-3 fw-bold text-white" type="submit" id="submit-button">
                        Buy
                    </button>


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

                            $('#buy-makeup-form').submit()
                        });
                    });
                });
        }

        getbraintree();

    </script>



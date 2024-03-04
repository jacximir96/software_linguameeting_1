<div class="margin-top20  borderWeek">
    <h5>Select your payment options</h5>
</div>


@if ( ! $section->course->isFree())

    <div class="row mt-4">
        <div class="col-12">
            <input type="radio" onclick="getbraintree()" value="brainTree" id="brainTree" class="" name="payment">
            <span class="font-weight-bold" for="brainTree">Credit Card</span>

        </div>
        <div class="col-12">
            {{Form::hidden('amount', null, ['id' => 'amount'])}}
            <input type="hidden" name="nonce" id="nonce" value="">
            <div id="dropin-container"></div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-5">
            <input type="radio"
                   name="payment"
                   value="payEnvivoCode"
                   id="payEnvivoCode"
                   onclick="bookstoreCode()"
                   class="{{$errors->has('payment') ? ' is-invalid ' : null}}">
            <span class="font-weight-bold" for="payEnvivoCode">Bookstore Code</span>
        </div>

        <div class="col-md-7">
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
            <p class="text-12">* This code is purchased at the bookstore and provide you access to LinguaMeeting for one term.</p>

        </div>
    </div>

    @if ($errors->has('payment'))
        <span class="invalid-feedback" style="display: block;" >
            <strong>{{ $errors->first('payment') }}</strong>
        </span>
    @endif

@else
    <div class="row">
        <div class="col-12">

            <div class="form-group radio-item event_free_course">
                <input type="radio" value="payFree" id="payFree" class="" name="payment" checked>
                <label for="payFree"> <strong>Open Access</strong></label>
            </div>
        </div>
    </div>
@endif




<div class="row mt-1">
    <div class=" col-12 btn-braintree  margin-top10" style="display: none;">
        <button type="button" id="submit-button" class="btn backgroundColor35b4b4 colorWhite float-left w-100">
            <span class="">Next</span>&nbsp;&nbsp;
            <span class="btn-group-addon"><i class="fas fa-arrow-right"></i></span>
        </button>
    </div>

    <div class="col-12 btn-bookstore margin-top10">
        <button type="button" class="btn backgroundColor35b4b4 colorWhite float-left w-100" onclick="submitRegister()">
            <span class="">Next</span>&nbsp;&nbsp;
            <span class="btn-group-addon"><i class="fas fa-arrow-right"></i></span>
        </button>
    </div>

</div>


<script src="https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.min.js"></script>

<script>

    function submitRegister() {
        $('#form-personal-data').submit()
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

                        $('#form-personal-data').submit()
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

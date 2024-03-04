<div class="card mt-3">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-file-invoice-dollar"></i> Enrollment Payment</span>
    </div>
    <div class="card-body padding-05-rem">

        <div class="row">
            <div class="col-md-6">
                <p class="my-0">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Type Payment</span>
                    {{$payment->methodPayment->name ?? '-'}}
                </p>
            </div>

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Value</span>
                    @if ($payment)
                        {{format_money($payment->value)}}
                    @else
                        -
                    @endif
                </p>
            </div>

        </div>

        <div class="row mt-2">

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">State</span>
                    Approved
                </p>
            </div>

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Date</span>
                    @if ($payment)
                        {{toDate($payment->paid_at)}}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
        <div class="row mt-2">

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Payment Id</span>
                    @if ($payment)
                        @if ($payment->registerCode)
                            {{$payment->registerCode->code}}
                        @else
                            {{$payment->payment_id}}
                        @endif
                    @else
                        -
                    @endif

                </p>
            </div>

            <div class="col-md-6">
                <p class="my-0 ">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Email Payment</span>
                    {{$payment->email ?? '-'}}
                </p>
            </div>
        </div>

        @if ($payment->refund)
            <div class="row mt-2">
                <div class="col-12">
                    <span class="d-block text-corporate-danger fw-bold text-decoration-underline">Payment Refunded</span>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-md-6">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Transaction Id</span>
                    <span class="d-block">{{$payment->refund->transaction_id}}</span>
                </div>

                <div class="col-md-6">
                    <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Refund At</span>
                    <span class="d-block">
                        {!! toDatetimeInTwoRow($payment->refund->refund_at) !!}
                    </span>
                </div>
            </div>

        @endif
    </div>
</div>

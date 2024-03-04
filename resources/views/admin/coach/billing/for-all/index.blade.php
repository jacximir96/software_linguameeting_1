@extends('layouts.app')

@section('content')


    <div class="row mb-5">

        <div class="col-xl-8 offset-xl-2">

            @include('common.form_message_errors')

            @include('admin.coach.billing.for-all.search_form')

            @if (isset($viewData))

                <div class="row mt-4">
                    <div class="col-12">

                        @include('admin.coach.billing.for-all.invoice_table')

                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            <a href="{{route('get.admin.coach.billing.for_all.file.download_billing', [$month->month(), $month->year()])}}"
                               class="btn btn-sm btn-warning text-dark me-3">
                                <i class="fa fa-download"></i> Download Billing
                            </a>

                            <a href="{{route('get.admin.coach.billing.for_all.file.download_batch_payment', [$month->month(), $month->year()])}}"
                               class="btn btn-sm btn-success text-white me-3">
                                <i class="fa fa-download"></i> Download Batch Payment File
                            </a>

                            <a href="{{route('get.admin.coach.billing.for_all.file.download_paypal_batch_payment', [$month->month(), $month->year()])}}"
                               class="btn btn-sm btn-info text-white">
                                <i class="fa fa-download"></i> Download Paypal Batch Payment File
                            </a>
                        </div>
                        <div>
                            <a href="{{route('get.admin.api.coach.billing.invoice.generate_from_month', [$month->month(), $month->year()])}}"
                               title="Generate Invoices"
                               id="generate-invoices-ajax"
                               class="btn btn-sm btn-success text-white">
                                <i class="fa fa-plus"></i> Generate All Invoices
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.app_modal')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'discount-type-form',
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row mt-3">

                        <div class="col-sm-4">
                            <label class="small mb-1 fw-bold @error('month') text-danger @enderror" for="month">Month</label>
                            <div class="form-group row">
                                <div class="col-12">
                                    {{Form::select('month', $form->optionsField('monthsOptions'), null,
                                    [   'class'=>'form-control form-select',
                                        'placeholder' => 'Select Month',
                                        'id' => 'month',
                                        ])}}
                                    @error('month')
                                    <span class="custom-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            @include('common.form-field.number', ['field' => 'year', 'label' => 'Year', 'min' => 2015, 'max' => date('Y'), 'step' => '1'])
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                Show Billing
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{Form::close()}}

            @if (isset($viewData))
                <div class="row mt-5">

                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            <span class="bg-corporate-color-light p-2 fw-bold me-2">{{writeMonth($viewData->getMonthBilling()->month())}}</span>
                            <span class="bg-corporate-color-light p-2 fw-bold">{{$viewData->getMonthBilling()->month()->year()}}</span>
                        </div>

                        <div class="text-end">
                            @if ($invoice)
                                <a href="{{route('get.admin.coach.billing.invoice.download', $invoice->id)}}"
                                   class="btn btn-xs btn-success"
                                   title="Download Invoice">
                                    <i class="fa fa-download me-1"></i> Download Invoice
                                </a>
                            @else
                                {{ Form::model($generateInvoiceForm->model(),  [
                                      'class' => '',
                                      'url'=> $generateInvoiceForm->action(),
                                      'autocomplete' => 'off',
                                      'id' =>'generate-invoice-form',
                                  ]) }}


                                    {{Form::hidden('month', null)}}
                                    {{Form::hidden('year', null)}}

                                    <button type="submit" class="btn btn-xs btn-success">
                                        <i class="fa fa-plus me-1"></i> Generate Invoice
                                    </button>

                                {{Form::close()}}
                            @endif
                        </div>


                    </div>

                    <div class="col-12 mt-4">

                        @if ($viewData->getMonthBilling()->isPayerBilling())
                            @include('admin.coach.billing.for-one.filtered.table_payer_coach', ['monthBilling' => $viewData->getMonthBilling()])
                        @else
                            @include('admin.coach.billing.for-one.filtered.table_individual_coach', ['monthBilling' => $viewData->getMonthBilling()])

                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-12 col-xl-9">

            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-dollar-sign me-1"></i>
                        Payments
                    </span>

                    <span>{{$timezone->name}}</span>

                </div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                                <thead>
                                <tr class="small">
                                    <th class="w-25">Payer</th>
                                    <th class="">Amount</th>
                                    <th class="">Method Payment</th>
                                    <th class="">Transaction Id</th>
                                    <th class="w-20">Paid At</th>
                                    <th class="">Refund</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($payments as $payment)

                                    <tr>
                                        <td>
                                            {{$payment->writeFullName()}}
                                            @if ($payment->isPublicUser())
                                                <span title="Public User">(*)</span>
                                            @endif
                                        </td>
                                        <td>{{format_money($payment->value)}}</td>
                                        <td>{{$payment->methodPayment->name}}</td>
                                        <td>{{$payment->transaction_id}}</td>
                                        <td>{!! toDatetimeInTwoRow($payment->paid_at, $timezone) !!}</td>
                                        <td>
                                            @if ($payment->hasRefund())
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$payments->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

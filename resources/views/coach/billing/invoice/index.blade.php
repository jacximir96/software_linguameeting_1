@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-12 col-lg-6">

            <div class="card my-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-file-invoice-dollar me-1"></i>
                Invoices
            </span>

                </div>
                <div class="card-body">

                    <div class="row mt-4">

                        <div class="col-12">

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>

                                </thead>

                                <tbody>

                                @foreach ($invoices as $invoice)

                                    <tr>

                                        <td>{{$invoice->month()->year()}}</td>
                                        <td>{{writeMonth($invoice->month())}}</td>
                                        <td>

                                            <a href="{{route('get.coach.billing.for_one.show_filtered',
                                                        [$coach->id, $invoice->month()->month(), $invoice->month()->year()])}}"
                                               class="open-modal"
                                               data-modal-reload="no"
                                               data-modal-size="modal-lg"
                                               data-modal-title='Salary Coach'
                                               title="Show Detail">
                                                {{format_money($invoice->total())}}
                                            </a>

                                        </td>
                                        <td>
                                            <a href="{{route('get.coach.billing.invoice.download', $invoice->hashId())}}"
                                               title="Download Invoice"
                                               class="btn btn-xs btn-success">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


@endsection

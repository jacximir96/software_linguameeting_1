@extends('layouts.app_modal')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-file-invoice-dollar me-1"></i>
                List of Invoices
            </span>
        </div>
        <div class="card-body">

            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->month()->year()}}</td>
                        <td>{{writeMonth($invoice->month())}}</td>
                        <td>{{toDate($invoice->date)}}</td>
                        <td>{{format_money($invoice->total())}}</td>

                        <td>
                            <a href="{{route('get.admin.coach.billing.invoice.download', $invoice->id)}}"
                               class="btn btn-xs btn-success"
                               title="Download Invoice">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-left" colspan="10">
                            <span class="bg-warning p-2 py-1 rounded text-white">Invoices not found</span>
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection

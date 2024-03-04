@extends('layouts.app')

@section('content')

    <div class="container px-4">
        <div class="row">
            <div class="col-12 col-xl-10 mt-2 mb-5">
                <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Detail</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>
                                {!! toDatetimeInTwoRow($payment->paid_at, $timezone) !!}
                            </td>
                            <td>

                                @foreach ($payment->detail as $detail)
                                    <span class="d-block mb-2">{{$detail->writePayable()}}</span>
                                @endforeach

                            </td>
                            <td>
                                {{format_money($payment->value)}}
                            </td>
                            <td>
                                {{$payment->methodPayment->name}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-left" colspan="10">
                                <span class="bg-warning p-2 py-1 rounded text-white">Payments not found</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

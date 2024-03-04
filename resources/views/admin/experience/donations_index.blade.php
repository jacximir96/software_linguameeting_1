@extends('layouts.app_modal')

@section('content')


    <div class="row">
        <div class="col-12">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr class="small">
                    <th>Last Name, Name</th>
                    <th>Email</th>
                    <th class="w-20">Donation</th>
                </tr>
                </thead>

                <tbody>

                @forelse($paymentsDetails as $paymentsDetail)

                    <tr>
                        <td>{{$paymentsDetail->payment->writeFullName()}}</td>
                        <td>{{$paymentsDetail->payment->email}}</td>
                        <td>{{format_money($paymentsDetail->payment->value)}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No users attendee</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{$paymentsDetails->render()}}
        </div>
    </div>

@endsection

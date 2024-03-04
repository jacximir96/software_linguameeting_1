@extends('layouts.app_modal')

@section('content')

    @if ( ! $makeupAvailability->isNeedMoreMakeups())

        @include('student.enrollment.session.makeup.buy.sufficient_available')

    @elseif ( ! $makeupAvailability->courseMakeup()->numberMakeupsForPurchase()->get())

        @include('student.enrollment.session.makeup.buy.purchase_not_permit')

    @elseif( ! $makeupAvailability->numMaxAvailableForPurchase()->get())

        @include('student.enrollment.session.makeup.buy.purchased_all')

    @else

        @include('student.enrollment.session.makeup.buy.buy_form')

    @endif


@endsection

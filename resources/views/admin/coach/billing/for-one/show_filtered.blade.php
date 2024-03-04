@extends('layouts.app_modal')

@section('content')

    <div class="row">

        <div class="col-12">

            <span class="bg-corporate-color-light p-2 fw-bold me-2">{{$coach->writeFullName()}}</span>

            <span class="bg-corporate-color-light p-2 fw-bold me-2">{{writeMonth($viewData->getMonthBilling()->month())}}</span>

            <span class="bg-corporate-color-light p-2 fw-bold">{{$viewData->getMonthBilling()->month()->year()}}</span>
        </div>

        <div class="col-12 mt-4">

            @if ($viewData->getMonthBilling()->isPayerBilling())
                @include('admin.coach.billing.for-one.filtered.table_payer_coach', ['monthBilling' => $viewData->getMonthBilling()])
            @else
                @include('admin.coach.billing.for-one.filtered.table_individual_coach', ['monthBilling' => $viewData->getMonthBilling()])

            @endif
        </div>
    </div>

@endsection

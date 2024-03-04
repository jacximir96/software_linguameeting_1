@extends('layouts.app_modal')

@section('content')

    <div class="sbp-preview">
        <div class="sbp-preview-content">

            <div class="row mt-1">

                <div class="col-6 mt-2">
                    <span class="fw-bold me-2">Coaches Of: </span><span class="bg-corporate-color-light p-2 fw-bold me-2">{{$coach->writeFullName()}}</span>
                </div>

                <div class="col-6 mt-2">
                    <span class="bg-corporate-color-light p-2 fw-bold me-2">{{writeMonth($viewData->getMonthBilling()->month())}}</span>

                    <span class="bg-corporate-color-light p-2 fw-bold">{{$viewData->getMonthBilling()->month()->year()}}</span>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 mt-4">

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="w-30">Coach</th>
                            <th>Hours</th>
                            <th>Salary</th>
                            <th>Incentives</th>
                            <th>Discounts</th>
                            <th>Total</th>
                        </tr>

                        </thead>

                        <tbody>

                        @foreach ($viewData->getCoachCoordinatedBillings() as $billing)

                            <tr>
                                <td>
                                    {{$billing->coach()->writeFullName()}}

                                </td>
                                <td>{{$billing->hours()}}</td>
                                <td>{{$linguaMoney->format($billing->monthSalary()->baseSalary()->getSalary())}}</td>
                                <td>
                                    @if ($billing->hasIncentives())
                                        {{$linguaMoney->format($billing->monthSalary()->baseIncentive()->total())}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($billing->hasDiscounts())
                                        {{$linguaMoney->format($billing->monthSalary()->baseDiscount()->total())}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{$linguaMoney->format($billing->monthSalary()->total())}}
                                </td>
                            </tr>

                        @endforeach


                        @if ($viewData->getCoachCoordinatedBillings()->count())
                            <tr class="fw-bold">
                                <td colspan="4"></td>
                                <td>Total</td>
                                <td>{{$linguaMoney->format($viewData->totalSalaryCoaches())}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

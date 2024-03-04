@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-calendar-day me-1"></i>
                Book Session
            </span>
        </div>
        <div class="card-body mb-5">

            <div class="row">
                <div class="col-xl-6">
                    <div class="row ">
                        <div class="col-12">
                            <span class="d-block fw-bold bg-corporate-color text-white p-1 rounded">
                                Book Session
                            </span>
                        </div>

                        <div class="col-12 mt-4 ">
                            <div class="row">
                                <div class="col-12 ps-4">
                                   <span class="bg-corporate-color-light text-corporate-dark-color fw-bolder p-1 h6">
                                        Session {{$sessionOrderPeriod->sessionOrderObject()->get()}}
                                    </span>
                                    @if ( ! $course->isFlex())
                                        @if ($sessionOrderPeriod->hasPeriod())
                                            <span class="d-block text-muted smalla mt-1">
                                                {{toMonthDayAndYear($sessionOrderPeriod->start_date, $utcTimezoneName)}} - {{toMonthDayAndYear($sessionOrderPeriod->end_date, $utcTimezoneName)}}
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-5 " id="div-info-weeks">
                            <div class="row">
                                <div class="col-12" id="week-browser"></div>
                                <div class="col-12" id="form-other-options" style="display:none">
                                    @include('student.enrollment.session.makeup.form_search_more_options', ['searchCoachFrom' => $searchCoachForm])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('student.enrollment.session.common_javascript', [
        'startDate' => \Carbon\Carbon::now(),
        'endDate' => $endDate,
        'sessionOrder' => $sessionOrder,
        'enrollment' => $enrollment,
    ])


@endsection

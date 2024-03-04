@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-calendar-day me-1"></i>
                Reschedule Session
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6">

                    <div class="row">

                        <div class="col-xl-3">
                            @include('student.enrollment.session.info_coach_common', [
                                'coach' => $session->coach,
                            ])
                        </div>

                        <div class="col-xl-6">
                           <span class="small">...¿debería ir algo aquí?...</span>
                        </div>
                    </div>

                    <div class="row mt-3">

                        <div class="col-xl-6">
                            <div class="row">
                                <div class="col-12">
                                    <span class="d-block fw-bold">
                                        Session {{$enrollmentSession->session_order}} - {{toMonthDayAndYearExtend($session->createTime('start_time'))}}
                                    </span>
                                    @if (isset($coachingWeek))
                                        <span class="d-block text-muted small">
                                            {{toMonthDayAndYear($coachingWeek->start_date)}}, {{toMonthDayAndYear($coachingWeek->end_date)}}
                                        </span>
                                    @endif

                                    <a href="{{route('get.student.enrollment.assignment.show', $enrollmentSession)}}"
                                       class="open-modal d-block mt-3 text-corporate-danger"
                                       data-modal-reload="no"
                                       data-modal-size="modal-xl"
                                       data-modal-height="h-90"
                                       data-modal-title="Session Assignment"
                                       title="Leave a tip">
                                        View Assignments
                                    </a>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row">

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
        'startDate' => $startDate,
        'endDate' => $endDate,
        'sessionOrder' => $sessionOrder,
        'enrollment' => $enrollment,
    ])

@endsection

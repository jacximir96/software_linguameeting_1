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


                <div class="col-12 col-xl-6 border rounded p-3">

                    <div class="row">


                        <div class="col-xl-6">
                            @include('student.enrollment.session.info_coach_common', [
                                'coach' => $session->coach,
                            ])
                        </div>

                        <div class="col-xl-6">
                            <span class="d-block fw-bold">
                                Session {{$enrollmentSession->session_order}} - {{toMonthDayAndYearExtend($session->createTime('start_time'))}}
                            </span>

                            <span class="d-block text-muted small">
                                {{toMonthDayAndYear($enrollmentSession->coachingWeek->start_date)}}, {{toMonthDayAndYear($enrollmentSession->coachingWeek->end_date)}}
                            </span>

                            <a href="{{route('get.student.enrollment.assignment.show', $enrollmentSession)}}"
                               class="open-modal d-block mt-2 text-corporate-danger small"
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



            <div class="row mt-3">
                <div class="col-12 col-xl-6 borde rounded p-3">
                    <p class="">
                        Sorry, <span class="text-corporate-danger fw-bold">you may only cancel your scheduled session</span> <span class="fw-bold">5 hours prior to its start time</span>.
                        <span class="fw-bold">New sessions should be booked 12-hours in advance</span>. Please try a different day or time to see coaches’ availability.
                    </p>

                    <p class="mt-1">
                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/kb/view/1791033345" target="_blank" title="Go to read">
                            Why do I need to book 12 hours in advance?
                        </a>
                    </p>

                    <p class="mt-4 text-start">
                        <a href="{{route('get.student.enrollment.show', $enrollmentSession->enrollment->hashId())}}" class="btn btn-sm bg-corporate-color text-white" title="Go Back">
                            Go back
                        </a>
                    </p>
                </div>

            </div>

        </div>
    </div>

@endsection

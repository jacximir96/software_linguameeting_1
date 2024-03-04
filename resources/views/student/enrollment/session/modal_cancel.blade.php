<div class="row">

    @php $scheduleSession = $enrollmentSession->scheduleSession() @endphp

    @if ($scheduleSession->isPast())
        <div class="col-12">
            <span class="d-block text-corporate-danger fw-bold">
                Cancel Session
            </span>
        </div>
    @else
        <div class="col-12">
            <span class="d-block text-corporate-danger fw-bold">
                IMPORTANT
            </span>
            <span class="d-block text-corporate-danger mt-2">
                You must cancel your session up to 5 hours prior.
            </span>
        </div>

    @endif

    <div class="col-12 mt-3">

        <span class="d-block fw-bold">
            Session {{$enrollmentSession->session_order}} - {{toMonthDayAndYearExtend($session->createTime('start_time'))}}
        </span>

        @if( $enrollmentSession->hasCoachingWeek())
            <span class="d-block text-muted small">
                {{toMonthDayAndYear($enrollmentSession->coachingWeek->start_date)}}, {{toMonthDayAndYear($enrollmentSession->coachingWeek->end_date)}}
            </span>
        @endif
    </div>


    @if ($scheduleSession->isPast())
        <div class="col-12 mt-4 mb-3 bg-corporate-color-light fw-bold text-success text-center">
            <span class="d-block">
                Esta sesión no se puede cancelar.
            </span>

            <span class="d-block mt-2">
                Finalizó el: {{ toMonthDayAndYearExtend($scheduleSession->end())}}
            </span>
        </div>
    @else

        @php $canChangeStatus = $enrollmentSession->canChangeStatus(config('linguameeting.course.session.hours_limit.cancel')); @endphp

        @if ( ! $canChangeStatus)
            <div class="row mt-4">
                <div class="col-10 offset-1 bg-reschedule text-white fw-bold rounded p-1 small">
                    Lo sentimos pero únicamente es posible cancelar la sesión hasta 5 horas antes del inicio de la misa.
                </div>
            </div>
        @endif

        <div class="col-12 mt-5 d-flex justify-content-between">
            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>

            @if ($canChangeStatus)
                <a href="{{route('get.student.session.book.cancel', $enrollmentSession->hashId())}}" class="btn btn-danger bg-corporate-danger">
                    Cancel Session
                </a>
            @else

                <a href="#" class="btn bg-cancel text-white">
                    Cancel Session
                </a>

            @endif
        </div>


    @endif



</div>

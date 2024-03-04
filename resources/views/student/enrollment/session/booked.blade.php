<div class="col-xl-3">
    @include('student.enrollment.session.info_coach')
</div>

<div class="col-xl-5">
    <div class="row">

        <div class="col-12">

                <span class="d-block fw-bold">
                    <span>Session {{$enrollmentSession->session_order}} - {{toMonthDayAndYearExtend($session->createTime('start_time'))}}</span>
                </span>

            <span class="d-block text-muted small">
                    {{toMonthDayAndYear($enrollmentSession->coachingWeek->start_date)}}, {{toMonthDayAndYear($enrollmentSession->coachingWeek->end_date)}}
                </span>

            <a href="{{route('get.student.enrollment.assignment.show', $enrollmentSession)}}"
               class="open-modal d-inline-block mt-2 text-corporate-danger small"
               data-modal-reload="no"
               data-modal-size="modal-xl"
               data-modal-height="h-90"
               data-modal-title="Session Assignment"
               title="Leave a tip">
                View Assignments
            </a>

            @if ($enrollmentSession->isRecovery())
                <span class="ms-3 text-warning-dark fw-bold small rounded p-1">Is Make-up Session</span>
            @endif

            @if ($enrollmentSession->isExtraSession())
                <span class="ms-3 text-warning-dark fw-bold small rounded p-1">Is Extra Session</span>
            @endif
        </div>

    </div>

    @if (isset($isCompleted))
        <div class="row mt-2 bg-corporate-color-light py-2 rounded">


            @if ($enrollmentSession->feedback)

                @php $feedback = $enrollmentSession->feedback @endphp

                <div class="col-xl-12">
                    <span class="fw-bold me-2">Puntuality:</span>
                    <span class="d-inline-block">{{$feedback->puntualityType->description}}</span>
                </div>

                <div class="col-xl-12 mt-1">
                    <span class="fw-bold me-2">Prepared for class:</span>
                    <span class="d-inline-block">{{$feedback->preparedClassType->description}}</span>
                </div>

                <div class="col-xl-12 mt-1">
                    <span class="fw-bold me-2">Participation:</span>
                    <span class="d-inline-block">{{$feedback->participationType->description}}</span>
                </div>
            @else
                <div class="col-12">
                    <span class="fa fa-warning">You don't have feedback yet</span>
                </div>
            @endif

        </div>

    @endif

</div>

<div class="col-xl-4 text-end">

    @if ($enrollmentSession->scheduleSession()->isPast())

        @if (isset($isCompleted))

            <div>
                @if ($enrollmentSession->enrollment->section->studentsCanSeeRecording() AND $enrollmentSession->session->zoomRecording)

                    <a href="{{$enrollmentSession->session->zoomRecording->play_url}}"
                       class="btn btn-sm bg-corporate-color text-white  mb-2"
                       title="Show Recording" target="_blank">
                        <i class="fa fa-video text-white me-1"></i> Show Recording
                    </a>

                @else
                    <a href="#"
                       class="btn btn-sm bg-corporate-color text-white  mb-2"
                       title="Show Recording" target="_blank">
                        <i class="fa fa-video text-white me-1"></i> Show Recording
                    </a>
                @endif
            </div>

            @if ($enrollmentSession->enrollment->isActive())
                @if ( ! $enrollmentSession->coachReview)
                    <a href="{{route('get.student.session.coach_review.create', $enrollmentSession->hashId())}}"
                       class="btn btn-sm bg-corporate-color text-white open-modal"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-size="modal-lg"
                       data-modal-height="h-90"
                       data-modal-title="Rate Session {{$enrollmentSession->session_order}} - {{toMonthDayAndYearExtend($session->createTime('start_time'))}}"
                       title='Rate Session'>
                        Rate Session
                    </a>
                @endif
            @endif

        @else

            @if ($enrollmentSession->enrollment->isActive())

                @if ($enrollmentSession->status->isMissed() OR $enrollmentSession->status->isNotCelebrated())

                    @if ($makeupAvailability->hasMakeupAvailable())
                        <a href="{{route('get.student.session.book.makeup.use.booked_session', $enrollmentSession->hashId())}}"
                           class="btn btn-sm bg-reschedule text-white d-inline-block m-2"
                           title="Use Make-up">
                            Make-up
                        </a>
                    @endif

                @endif

            @endif

        @endif
    @else

        @if ($enrollmentSession->enrollment->isActive())
            @if ($enrollmentSession->scheduleSession()->isToday() AND $enrollmentSession->scheduleSession()->isFuture() )

                <div class="mb-3">
                    @if ($enrollmentSession->session->isPossibleJoinSession())
                        <a href="{{route('get.student.session.book.session.join', $enrollmentSession->hashId())}}" class="btn btn-sm bg-corporate-color text-white" target="_blank">
                            Join Session
                        </a>
                    @else
                        <a href="#" class="btn btn-sm bg-corporate-color text-white" target="_blank">
                            Join Session
                        </a>
                    @endif

                    <span class="d-block text-muted small">
                        Activated 2 min before session
                    </span>
                </div>

            @endif

            <a href="{{route('get.student.session.book.reschedule.init', $enrollmentSession->hashId())}}" class="btn btn-sm bg-reschedule text-white me-2">
                Reschedule
            </a>

            <a href="#"
               class="btn btn-sm bg-cancel coral-red"
               title="Cancel Session"
               data-bs-toggle="modal"
               data-bs-target="#cancel-session-{{$enrollmentSession->hashId()}}">
                Cancel
            </a>
        @endif
    @endif


</div>

@if ($enrollmentSession->enrollment->isActive())
    @include('common.modal_info', [
           'modalId' => 'cancel-session-'.$enrollmentSession->hashId(),
           'modalTitle' => 'Cancel Session',
           'size' => 'modal-md',
           'path' => 'student.enrollment.session.modal_cancel',
           'enrollmentSession' => $enrollmentSession,
           'noFooter' => true,
           'timezone' => $enrollmentSession->enrollment->user->timezone,
       ])

@endif

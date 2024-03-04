<div class="col-5 ">
    <span class="bg-corporate-color-light p-1 rounded fw-bold text-corporate-dark-color fw-bold">Session {{$enrollmentSession->sessionOrder()->get()}}</span>

    @if ($enrollmentSession->makeup)
        <span class="text-corporate-dark-color small d-inline-block fw-bold ms-2 p-1 bg-corporate-color-light">
            (Makeup
            @if ($enrollmentSession->recovered)
                <span class="">Sess. {{$enrollmentSession->recovered->sessionOrder()->get()}}</span>
            @endif
            )

        </span>
    @elseif ($enrollmentSession->extraSession)
        <span class="text-corporate-dark-color small d-inline-block fw-bold ms-2 p-1 bg-corporate-color-light">(Extra Session)</span>
    @endif
</div>

<div class="col-7 text-end ">
    @if ($enrollmentSession->isReserved())
        <span class="d-block bg-corporate-color-light">
            <span class="text-decoration-underline">{{toDayMonthAndYear($enrollmentSession->scheduleSession()->start(), $timezone)}}</span>
            {{toTime24h($enrollmentSession->scheduleSession()->start())}} -
            {{toTime24h($enrollmentSession->scheduleSession()->end())}}
        </span>

        <span class="d-block bg-corporate-color-light small">{{$timezone->name}}</span>
    @else
        <span class="d-inline-block text-decoration-underline bg-corporate-color-light">Not Reserved</span>
    @endif
</div>

<div class="col-5">

    <div class="row">
        <div class="col-12">
            <span class="small text-corporate-dark-color fw-bold">Status</span>
            {{Form::select('session_id',
                            $viewData->optionsGroup()->optionsField('sessionStatusOptions'),
                            $enrollmentSession->session_status_id,
                            [
                                'class' => 'form-control form-select select-update-status-session d-inline-block',
                                'data-session-id' => $enrollmentSession->id,
                                'data-url-change-status' => route('post.admin.api.course.session.status.change', $enrollmentSession->id)
                            ])}}
        </div>
        <div class="col-12 mt-2">
            <span class="small d-block text-corporate-dark-color fw-bold">Coach</span>
            @if ($enrollmentSession->session->coach)
                <img src="{{asset('assets/img/flags/'.$enrollmentSession->session->coach->country->flagFile())}}"
                     title="Flag of {{$enrollmentSession->session->coach->country->name}}"
                     class="img-thumbnail flag-icon-25 me-1"/>
                <a href="{{route('get.admin.coach.show', $enrollmentSession->session->coach->id)}}"
                   title="Show Coach"
                   class=" text-primary"
                   target="_blank">
                    {{$enrollmentSession->session->coach->writeFullName()}}
                </a>

            @else
                <span class="fst-italic small">Not coach</span>
            @endif
        </div>
        <div class="col-12 mt-2">
            <span class="small d-block text-corporate-dark-color fw-bold">Recording</span>
            @if ($enrollmentSession->session->zoomRecording)
                <a href="{{$enrollmentSession->session->zoomRecording->play_url}}" title="View Recording" target="_blank">
                    View
                </a>
            @else
                <span class="fst-italic small">Not exists</span>
            @endif
        </div>
        <div class="col-12 mt-4 text-start">

            <a href="{{route('get.admin.course.session.delete', $enrollmentSession->id)}}"
               title="Delete Session"
               onclick="return confirm('Are you sure you want to delete this assignment?');"
               class="text-corporate-danger">
                Delete Session
            </a>
        </div>
    </div>
</div>



<div class="col-7">

    @if ($enrollmentSession->feedback)

        <div class="row">
            <div class="col-12  ">
                <span class="small text-corporate-dark-color fw-bold">Puntuality</span>
                {{Form::select('session_id',
                            $viewData->optionsGroup()->optionsField('puntualityOptions'),
                            $enrollmentSession->feedback->puntuality_type_id,
                            [
                                'class' => 'form-control form-select select-update-student-feedback d-inline-block',
                                'data-session-feedback-type' => 'puntuality',
                                'data-url-change' => route('post.admin.api.course.session.feedback.student.change', $enrollmentSession->id)
                            ])}}
            </div>
            <div class="col-12 ">
                <span class="small text-corporate-dark-color fw-bold">Prepared</span>
                {{Form::select('session_id',
                                $viewData->optionsGroup()->optionsField('preparedClassOptions'),
                                $enrollmentSession->feedback->prepared_class_type_id,
                                [
                                    'class' => 'form-control form-select select-update-student-feedback d-inline-block',
                                    'data-session-feedback-type' => 'prepared-class',
                                    'data-url-change' => route('post.admin.api.course.session.feedback.student.change', $enrollmentSession->id)
                                ])}}
            </div>
            <div class="col-12 ">
                <span class="small text-corporate-dark-color fw-bold">Participation</span>
                {{Form::select('session_id',
                                $viewData->optionsGroup()->optionsField('participationOptions'),
                                $enrollmentSession->feedback->participation_type_id,
                                [
                                    'class' => 'form-control form-select select-update-student-feedback d-inline-block',
                                    'data-session-feedback-type' => 'participation',
                                    'data-url-change' => route('post.admin.api.course.session.feedback.student.change', $enrollmentSession->id)
                                ])}}
            </div>

            <div class="col-12 ">
                <span class="small text-corporate-dark-color fw-bold">Observations</span>
                <p class="small my-0">
                    @if ($enrollmentSession->feedback->hasObservations())
                            {!! $enrollmentSession->feedback->observations !!}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

    @endif
</div>

<div class="col-12 ">
    <hr class="my-3 bg-corporate-dark-color"/>
</div>


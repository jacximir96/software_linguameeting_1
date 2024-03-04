<div class="accordion accordion-flush mt-4" id="accordion-sessions">

    @if ($sessionsBag->hasMissed())
        <div class="accordion-item" style="border:1px solid #ddd !important;">
            <h2 class="accordion-header" id="missed-heading">
                <button class="accordion-button collapsed fs-5"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#missed-sessions-collapse"
                        aria-expanded="false"
                        aria-controls="missed-sessions-collapse">
                    {{$sessionsBag->missedSessionsCount()}} Missed {{$sessionsBag->missedSessionsCount() ==1 ? 'Session' : 'Sessions'}}
                </button>
            </h2>
            <div id="missed-sessions-collapse" class="accordion-collapse collapse" aria-labelledby="missed-heading" data-bs-parent="#accordion-sessions">
                <div class="accordion-body">

                    @if ($enrollment->isActive())
                    <div class="row">
                        <div class="col-12 text-end">
                            <a href="{{route('get.student.session.book.makeup.buy', $enrollment->hashId())}}"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-height="h-90"
                               data-modal-size="modal-lg"
                               data-modal-title="Buy Make-up"
                               class="open-modal bg-corporate-danger-light text-danger p-1 rounded small">
                                Make-up
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        @include('student.enrollment.sessions-bag.sessions', [
                            'enrollment' => $viewData->enrollment(),
                            'itemBag' => $sessionsBag->missedSessions()
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($sessionsBag->hasTodaySessions())

            <div class="accordion-item mt-5" style="border:1px solid #ddd !important;">
                <h2 class="accordion-header" id="today-heading">
                    <button class="accordion-button  fs-5"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#today-sessions-collapse"
                            aria-expanded="false"
                            aria-controls="today-sessions-collapse">
                        Today
                    </button>
                </h2>
                <div id="today-sessions-collapse" class="accordion-collapse collapse show" aria-labelledby="today-heading" data-bs-parent="#accordion-sessions">
                    <div class="accordion-body">
                        <div class="row">
                            @include('student.enrollment.sessions-bag.sessions', [
                                'enrollment' => $viewData->enrollment(),
                                'itemBag' => $sessionsBag->todaySessions()
                            ])
                        </div>
                    </div>
                </div>
            </div>
    @endif

    @if ($sessionsBag->hasNext())

        <div class="accordion-item mt-5" style="border:1px solid #ddd !important;">
            <h2 class="accordion-header" id="next-heading">
                <button class="accordion-button collapsed fs-5"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#next-sessions-collapse"
                        aria-expanded="false"
                        aria-controls="next-sessions-collapse">
                    {{$sessionsBag->nextSessionsCount()}} Next {{$sessionsBag->nextSessionsCount() ==1 ? 'Session' : 'Sessions'}}
                </button>
            </h2>
            <div id="next-sessions-collapse" class="accordion-collapse collapse" aria-labelledby="next-heading" data-bs-parent="#accordion-sessions">
                <div class="accordion-body">
                    @include('student.enrollment.sessions-bag.sessions', [
                            'enrollment' => $viewData->enrollment(),
                            'itemBag' => $sessionsBag->nextSessions(),
                            'showIntroSession' => true,
                        ])

                    @if ($showSurvey)
                        <div class="row">
                            <div class="col-12 mt-5 pt-2 bg-corporate-color-light d-flex justify-content-between">
                                <span class=" fw-bold p-2">
                                    <i class="fa fa-question-circle"></i> We want to hear from you
                                </span>
                                <div>
                                    @if ($viewSurvey->isDefault())
                                        <a href="{{route('get.student.enrollment.survey.take.default', $enrollment->hashId())}}"
                                           target="_blank"
                                           title="{{$viewSurvey->description()}}"
                                           class="btn btn-sm bg-corporate-color text-white">Take the survey</a>
                                    @else

                                        <a href="{{route('get.student.enrollment.survey.take', [$enrollment->hashId(), $viewSurvey->survey()->hashId()])}}"
                                           target="_blank"
                                           title="{{$viewSurvey->description()}}"
                                           class="btn btn-sm bg-corporate-color text-white">Take the survey</a>

                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif


    @if ($sessionsBag->hasCompleted())

        <div class="accordion-item mt-5" style="border:1px solid #ddd !important;">
            <h2 class="accordion-header" id="completed-heading">
                <button class="accordion-button collapsed fs-5"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#completed-sessions-collapse"
                        aria-expanded="false"
                        aria-controls="completed-sessions-collapse">
                    {{$sessionsBag->completedSessionsCount()}} Completed Sessions
                </button>
            </h2>
            <div id="completed-sessions-collapse" class="accordion-collapse collapse" aria-labelledby="completed-heading" data-bs-parent="#accordion-sessions">
                <div class="accordion-body">
                    @include('student.enrollment.sessions-bag.sessions', [
                            'enrollment' => $viewData->enrollment(),
                            'itemBag' => $sessionsBag->completedSessions(),
                            'isCompleted' => true,
                        ])
                </div>
            </div>
        </div>
    @endif
</div>



<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body container">
                <div class="row">
                    <div class="col-md-10">
                        Session {{$enrollmentSession->session_order}} -
                        {{toDayMonthAndYear($enrollmentSession->scheduleSession()->start(), $timezone->name)}} 05 May 2023
                    </div>

                    <div class="col-md-2 text-corporate-color text-right">
                        <a href="{{route('get.instructor.students.enrollment.session.feedback.show_form', $enrollmentSession->feedback->hashId())}}"
                           title="Edit review"
                           class="open-modal text-corporate-color"
                           data-modal-size="modal-lg"
                           data-modal-reload="yes"
                           data-reload-type="parent"
                           data-modal-title="Edit review">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </div>
                </div>


                <div class="row mt-2 text-center float-none">
                    <div class="col-md-3">
                        <div class="text-corporate-dark-color points-grade">
                            <strong>{{$enrollmentSession->feedback->preparedClassType->grade()->get()}}</strong>
                        </div>
                        <div>
                            Preparedness
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text-corporate-dark-color points-grade">
                            <strong>{{$enrollmentSession->feedback->puntualityType->grade()->get()}}</strong>
                        </div>
                        <div>
                            Puntuality
                        </div>
                    </div>

                    <div class="col-md-3">

                        <div class="text-corporate-dark-color points-grade">
                            <strong>{{$enrollmentSession->feedback->participationType->grade()->get()}}</strong>
                        </div>

                        <div>
                            Participation
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text-corporate-dark-color points-grade">
                            <strong>{{$enrollmentSession->feedback->grade()->total()->get()}}</strong>
                        </div>
                        <div>
                            Total
                        </div>
                    </div>
                </div>

                @if ($enrollmentSession->feedback->hasObservations())
                    <div class="row mt-4">
                        <div class="col-12">
                            <span class="d-block fw-bold small">Observations</span>
                            <p class="small text-muted">
                                {{html_entity_decode($enrollmentSession->feedback->observations)}}
                            </p>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>

</div>

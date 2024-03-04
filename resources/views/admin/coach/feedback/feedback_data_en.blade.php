<div class="card">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-comments"></i> Feedback</span>
    </div>
    <div class="card-body padding-05-rem">

        <div class="row gx-0">
            <div class="col-md-4 ">
                <p class="my-0 p-1 bg-corporate-color-light text-corporate-dark-color ">
                    <span class="fw-bold">Feedback</span>
                </p>
            </div>

            <div class="col-md-4">
                <p class="my-0 p-1 bg-corporate-color-light text-corporate-dark-color ">
                    <span class="fw-bold">Observations</span>
                </p>
            </div>

            <div class="col-md-4">
                <p class="my-0 p-1 bg-corporate-color-light text-corporate-dark-color ">
                    <span class="fw-bold">Comments</span>
                </p>
            </div>
        </div>


        @foreach ($wrapper->feedbackSortedByTypes() as $typeFeedback)

            <div class="row mt-3">
                <div class="col-12">
                    <p class="my-0 p-1 ps-2 bg-corporate-color-light text-corporate-dark-color fw-bold">
                        {{$types->get($typeFeedback->id())->eng_title}}
                    </p>
                </div>
            </div>

            @foreach ($typeFeedback->subtypes() as $subtypeFeedback)

                <div class="row mt-1 py-1 gx-0" style="border-bottom: 1px solid #eee;">
                    <div class="col-md-4">
                        <p class="my-0 ps-3">
                            <i class="fa fa-minus fa-xs "></i>
                            <span class="d-inline-block fw-bold ">
                                {{$subtypes->get($subtypeFeedback->id())->eng_title}}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <p class="my-0 ps-1">
                            <span class="d-inline-block text-corporate-dark-color">
                                {{$observations->get($subtypeFeedback->observationId())->eng_title ?? '-'}}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-4">

                        <div class="row">
                            <div class="col-12">
                                <p class="my-0 ps-2">
                                    <span class="">
                                        {{$suggestions->get($subtypeFeedback->suggestionId())->eng_title ?? '-'}}
                                    </span>
                                </p>
                            </div>
                            @if ($subtypeFeedback->hasAlternativeText())
                                <div class="col-12 mt-2 small">
                                    <p class="my-0 ps-2">
                                        <span class="d-block fw-bold">Sugerencia alternativa</span>
                                        <span class="small d-inline-block text-corporate-dark-color d-block">
                                        {{ $subtypeFeedback->alternativeText() ?? '-' }}
                                    </span>
                                    </p>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>

            @endforeach
        @endforeach


        <div class="row mt-3">
            <div class="col-12">
                <p class="my-0 p-1 ps-2 bg-corporate-color-light text-corporate-dark-color fw-bold">
                    Comment
                </p>
            </div>
            <div class="col-12 mt-2 ">
                <p class="p-2 border rounded ">
                    @if ($wrapper->get()->hasObservations())
                        {!! $wrapper->get()->observations !!}
                    @else
                        -
                    @endif
                </p>

            </div>
        </div>

    </div>
</div>

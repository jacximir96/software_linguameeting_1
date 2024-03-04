
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


        @foreach ($form->feedbackSortedByTypes() as $typeFeedback)

            <div class="row mt-3">
                <div class="col-12">
                    <p class="my-0 p-1 ps-2 bg-corporate-color-light text-corporate-dark-color fw-bold">
                        @if ($wrapper->language()->isSpanish())
                            {{$types->get($typeFeedback->id())->es_title}}
                        @else
                            {{$types->get($typeFeedback->id())->eng_title}}
                        @endif

                    </p>
                </div>
            </div>

            @foreach ($typeFeedback->subtypes() as $subtypeFeedback)

                <div class="row mt-1 py-1 gx-0" style="border-bottom: 1px solid #eee;">
                    <div class="col-md-4">
                        <p class="my-0 ps-3">
                            <i class="fa fa-minus fa-xs "></i>
                            <span class="d-inline-block fw-bold ">
                                @if ($wrapper->language()->isSpanish())
                                    {{$subtypes->get($subtypeFeedback->id())->es_title}}
                                @else
                                    {{$subtypes->get($subtypeFeedback->id())->eng_title}}
                                @endif

                            </span>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <p class="my-0 ps-1">
                            <span class="d-inline-block text-corporate-dark-color">
                                    {{Form::select('observations['.$typeFeedback->id().']['.$subtypeFeedback->id().']', $form->observationsOptions ($typeFeedback->id(), $subtypeFeedback->id(), $wrapper->language()), null,
                                    [
                                        'placeholder' => 'Select Observation',
                                        'id' => '',
                                        'class' => ' form-control form-select '],
                                    )}}

                                    @error('coach_id')
                                        <span class="custom-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @if ($wrapper->language()->isSpanish())
                                    {{$observations->get($subtypeFeedback->observationId())->es_title ?? '-'}}
                                @else
                                    {{$observations->get($subtypeFeedback->observationId())->eng_title ?? '-'}}
                                @endif
                            </span>
                        </p>
                    </div>

                    <div class="col-md-4">
                        <p class="my-0 ps-1">
                            <span class="d-inline-block text-corporate-dark-color">
                                    @php $key = 'suggestions['.$typeFeedback->id().']['.$subtypeFeedback->id().']' @endphp
                                    {{Form::select( $key, $form->suggestionsOptions ($typeFeedback->id(), $subtypeFeedback->id(), $wrapper->language()), null,
                                    [
                                        'placeholder' => 'Select Suggestion',
                                        'id' => '',
                                        'class' => ' form-control form-select '],
                                    )}}

                                @error($key)
                                    <span class="custom-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if ($wrapper->language()->isSpanish())
                                    {{$suggestions->get($subtypeFeedback->suggestionId())->es_title ?? '-'}}
                                @else
                                    {{$suggestions->get($subtypeFeedback->suggestionId())->eng_title ?? '-'}}
                                @endif
                            </span>
                        </p>
                        <p>
                            @php $key = 'alternatives_text['.$typeFeedback->id().']['.$subtypeFeedback->id().']' @endphp
                            {{Form::textarea($key,  null, [   'class'=>'form-control','rows' => 2])}}
                        </p>
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
                    @include('common.form-field.textarea', ['field' => 'observations_text',
                                                                            'label' => 'Observations',
                                                                            'id' => 'ckeditor',
                                                                            'rows' => 5,
                                                                            'ckEditor' => 'ckeditor-basic'])
                </p>

            </div>
        </div>

    </div>


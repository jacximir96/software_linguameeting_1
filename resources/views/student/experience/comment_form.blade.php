@extends('layouts.app_modal')

@section('content')

    <div class="container mb-5">

        <div class="row">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'experience-public-rate-form',
           ]) }}
            <div class="col-12">

                <div class="row">
                    <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold">
                        Rate Experience
                    </span>
                        <span class="fw-bold text-corporate-dark-color">
                        <span class="fw-bold text-decoration-underline">{{$experience->title}}</span>
                    </span>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 textç">
                        <div class="ratingExperience h1 color-gold " id="rating"></div>
                        {{Form::hidden('rate', null, ['class' => 'rate form-control '.($errors->has('rate') ? ' is-invalid ' : null), 'id'=> 'rate'])}}
                    </div>
                </div>

                <div class="row margin-top10">

                    <div class="col-md-12">
                        <span class="fw-bold">Feedback for the host</span>
                        {{Form::textarea('comment', null, [
                              'class' => 'form-control '.($errors->has('comment') ? ' is-invalid ' : null),
                              'rows' => 3,
                              'id'=> 'comment'
                          ])}}
                        @error('comment')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>


            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm btn-bold px-4 me-3" type="submit" id="submit-button">
                        Send Rate
                    </button>

                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">No</button>
                </div>
            </div>

            {{Form::close()}}

        </div>
    </div>

    <script>

        $(document).ready(function () {

            var options = {
                max_value: 5,
                step_size: 1,
                initial_value: {{old('rate') ?? 5}}
            };
            $(".ratingExperience").rate(options);

            jQuery(document).on('submit', '#experience-public-rate-form', function (event) {

                rate = $('#rating').attr('data-rate-value')
                $('#rate').val(rate)

                return true;
            });
        });
    </script>
@endsection

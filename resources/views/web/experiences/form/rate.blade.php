@extends('layouts.app_modal')

@section('content')

    <div class="container mt-5">


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

                <div class="row margin-top20">
                    <div class="col-md-12">
                        <div class="ratingExperience color-gold margin_auto" id="rating"></div>
                        {{Form::hidden('rate', null, [
                              'class' => 'rate form-control '.($errors->has('rate') ? ' is-invalid ' : null),
                              'id'=> 'rate'
                          ])}}
                        @error('rate')
                        <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row margin-top10">

                    <div class="col-md-12">
                        <p class="text-16">Feedback for the host:</p>
                        {{Form::textarea('comment', null, [
                              'class' => 'form-control '.($errors->has('comment') ? ' is-invalid ' : null),
                              'rows' => 2,
                              'id'=> 'comment'
                          ])}}
                        @error('comment')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mt-3">

                    <div class="col-12">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                        {{Form::text('name', null, [
                                'id' => 'name',
                                'class' => 'form-control ' .($errors->has('name') ? ' is-invalid ' : null),
                        ])}}
                        @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-12">
                        <label for="last_name" class="col-md-4 col-form-label text-md-end">Last name</label>
                        {{Form::text('lastname', null, [
                                'id' => 'lastname',
                                'class' => 'form-control ' .($errors->has('lastname') ? ' is-invalid ' : null),

                        ])}}
                        @error('lastname')
                        <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-12">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                        {{Form::text('email', null, [
                                'id' => 'email',
                                'class' => 'form-control ' .($errors->has('email') ? ' is-invalid ' : null),

                        ])}}
                        @error('email')
                        <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-sm-6 offset-sm-3 d-flex justify-content-end">
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

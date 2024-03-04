@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-12">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'change-sectionform',
           ]) }}

            <div class="row">
                <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold text-corporate-dark-color">
                        Change Section/Course
                    </span>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <p>
                        You are going to change your course/section.
                    </p>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12">
                    <label class="fw-bold" for="amount">New Class ID</label>
                    {{Form::text('code', null, ['id' => 'class-code',
                                                    'class' => 'form-control '.($errors->has('code') ? ' is-invalid ' : null),
                                                    'min' => 0,
                                                    'step' => '0.01'])}}
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mt-3">
                <div class="col-12">
                    <p class="text-danger fw-bold">
                        Remember if you change your course, you will need to book your sessions again.
                    </p>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-secondary px-4 close-modal" data-bs-dismiss="modal">No</button>

                    <button class="btn bg-corporate-color text-white btn-sm btn-bold px-4" type="submit" id="submit-button">
                        Change
                    </button>
                </div>
            </div>


            {{Form::close()}}

        </div>
    </div>
@endsection

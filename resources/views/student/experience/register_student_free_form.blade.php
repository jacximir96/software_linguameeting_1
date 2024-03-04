@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-12">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'register-student-experience-form',
           'files' => true,
           ]) }}

            <div class="row">
                <div class="col-12 p-2 bg-corporate-color-light ">
                    <span class="fw-bold text-corporate-dark-color">
                        Register in <span class="fw-bold text-decoration-underline">{{$experience->title}}</span>
                    </span>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-12 col-sm-6 offset-sm-3 p-3 rounded">
                    <span class="fw-bold me-2  fw-bold" >Price</span>
                    <span class="bg-corporate-color-light text-success fw-bold p-1">Free Experience</span>
                </div>

                <div class="col-12 col-sm-6 offset-sm-3 p-3 fw-bold mt-3">
                    <p>
                        Are you sure you want to book this experience?
                    </p>
                </div>



            <div class="row mt-4">
                <div class="col-12 text-end">
                    <button class="btn btn-primary btn-sm btn-bold px-4 me-3" type="submit" id="submit-button">
                        Yes
                    </button>

                    <button type="button" class="btn btn-sm btn-secondary px-4 close-modal">No</button>
                </div>
            </div>


            {{Form::close()}}

        </div>
    </div>
@endsection

@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-12">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'generate-google-calendar-form',
           'files' => true,
           ]) }}


            <div class="row">
                <div class="col-6 col-lg-3">
                    <label class="small fw-bold mb-1" for="name">Date Start</label>
                    {{Form::date('start_date', null, ['class' => 'form-control', 'id' => 'start_date'])}}
                    @error('start_date')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-6 col-lg-3">
                    <label class="small fw-bold mb-1" for="name">Date End</label>
                    {{Form::date('end_date', null, ['class' => 'form-control', 'id' => 'end_date'])}}
                    @error('end_date')
                    <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12 text-end">
                    <button class="btn btn-sm bg-corporate-color text-white btn-bold px-4" type="submit">
                        Generate
                    </button>
                </div>
            </div>


            {{Form::close()}}

        </div>
    </div>
@endsection

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
                <div class="col-4 col-md-3 col-lg-2">
                    <label class="small fw-bold mb-1" for="name">Start Date</label>
                    {{Form::date('start_date', null, ['class' => 'form-control', 'id' => 'start_date'])}}
                    @error('start_date')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-4 col-md-3 col-lg-2">
                    <label class="small fw-bold mb-1" for="name">End Date</label>
                    {{Form::date('end_date', null, ['class' => 'form-control', 'id' => 'end_date'])}}
                    @error('end_date')
                    <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-12 text-left">
                    <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                        Generate
                    </button>
                </div>
            </div>


            {{Form::close()}}

        </div>
    </div>
@endsection

@extends('layouts.app_modal')

@section('content')



    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'makeup-form'
    ])
   }}



    <div class="row mt-3">
        <div class="col-6 {{$errors->has('is_free') ? 'div-invalid' : null}}">
            <label class="mb-1 d-block fw-bold @error('is_free') text-danger @enderror" for="flexCheckDefault">Free</label>
            {{Form::radio('is_free', 1, null, ['class' => 'form-check-input'])}}
        </div>

        <div class="col-6 {{$errors->has('is_free') ? 'div-invalid' : null}}">
            <label class="mb-1 d-block fw-bold @error('is_free') text-danger @enderror" for="flexCheckDefault">Paid</label>
            {{Form::radio('is_free', 0, null, ['class' => 'form-check-input'])}}
        </div>

        @error('is_free')
        <span class="custom-invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>


    <div class="row mt-3">
        <div class="col-12 text-end">
            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                Save
            </button>
        </div>
    </div>
    {{Form::close()}}

@endsection


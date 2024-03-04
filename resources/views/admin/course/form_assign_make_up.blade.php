@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'assign-make-up-form'
   ]) }}


        <div class="row mt-3">
            <div class="col-6">
                @include('common.form-field.number', ['field' => 'number_makeups', 'label' => 'Makeups Numbers', 'min' => 1, 'step' => 1, 'required' => true])
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <label class=" mb-1 fw-bold" for="name">Type</label>
            </div>

                <div class="col-6 text-center mt-2">
                    {{Form::radio('is_free', 1, null, ['id' => '', 'class'=>''])}} For Free
                </div>

                <div class="col-6 text-left mt-2">
                    {{Form::radio('is_free', 0, null, ['id' => '', 'class'=>''])}} For Purchase
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

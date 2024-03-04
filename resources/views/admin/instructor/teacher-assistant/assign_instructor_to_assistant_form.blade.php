@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
       'class' => '',
       'url'=> $form->action(),
       'autocomplete' => 'off',
       'id' =>'assign-instructor-to-assistant-form'
   ]) }}

    <div class="row">
        <div class="col-12">
            <span class="text-primary fw-bold">Assign instruct to: {{$assistant->writeFullName()}}</span>
        </div>
    </div>
    <div class="form-group row mt-4">
        <div class="col-12 text-600">
            <span class="mb-2 small @error('instructor_id') text-danger-disabled.. @enderror "></span>
        </div>
        <div class="col-12">
            @if ($form->hasIntructorsForSelect())
            {{Form::select('instructor_id', $form->instructorOptions(),null, [
                                'placeholder' => 'Select Instructor',
                                'id' => 'instructor_id',
                                'class' => ' form-control form-select '.($errors->has('instructor_id') ? ' is-invalid ' : '')],
                                )}}

            @error('instructor_id')
                <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @else
                <span class="text-dark d-block mt-3">
                    <i class="fa fa-exclamation-triangle text-warning"></i> There are currently no instructors at the university to be eligible for selection
                </span>
            @endif
        </div>
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

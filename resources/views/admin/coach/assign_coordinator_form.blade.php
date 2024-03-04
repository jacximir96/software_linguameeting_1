@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
       'class' => '',
       'url'=> $form->action(),
       'autocomplete' => 'off',
       'id' =>'assign-coach-coordinator-form'
   ]) }}

    <div class="row">
        <div class="col-12">
            <span class="text-primary fw-bold">Assign coach coordinator to: {{$coach->writeFullName()}}</span>
        </div>
    </div>
    <div class="form-group row mt-4">
        <div class="col-12 text-600">
            <span class="mb-2 small @error('coach_id') text-danger-disabled.. @enderror "></span>
        </div>
        <div class="col-12">
            @if ($form->hasCoachesCoordinatorsForSelect())
                {{Form::select('coach_id', $form->coachesOptions(),null, [
                                    'placeholder' => 'Select Coach',
                                    'id' => 'coach_id',
                                    'class' => ' form-control form-select '.($errors->has('coach_id') ? ' is-invalid ' : '')],
                                    )}}

                @error('coach_id')
                    <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            @else
                <span class="text-dark d-block mt-3">
                    <i class="fa fa-exclamation-triangle text-warning"></i> There are currently no coach to be eligible for selection
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

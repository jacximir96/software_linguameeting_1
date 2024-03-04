@extends('layouts.app_modal')

@section('content')



    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'change-course-coordinator-form'
   ]) }}

        <div class="row mt-3">
            <div class="col-12">
                @include('common.form-field.select', [  'field' => 'instructor_id',
                                                         'label' => 'Course Coordinator',
                                                         'optionsField' => 'courseCoordinatorsOptions',
                                                         'placeholder' => 'Select Coordinator',])

                <span class="text-muted small mt-2 d-block">
                    Para quitar al coordinador del curso, quítalo del selector y pulsa en guardar (#trans)
                </span>

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

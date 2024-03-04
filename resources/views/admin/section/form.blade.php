@extends('layouts.app_modal')

@section('content')



    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'section-form'
   ]) }}

    <div class="row mt-3">
        <div class="col-12">
            @include('common.form-field.select', [  'field' => 'instructor_id',
                                                     'label' => 'Instructor',
                                                     'optionsField' => 'instructorOptions',
                                                     'placeholder' => 'Select Instructor',
                                                     'titleFieldform' => true,
                                                     ])
        </div>
        <div class="col-12">
            <a  href="{{route('get.common.course.instructor.simple.create', [$course->university->id, $course->language->id])}}"
                class="small open-modal text-success fw-bold"
                data-modal-reload="yes"
                data-reload-type="parent"

                data-modal-title='Create Instructor'>
                <i class="fa fa-plus"></i> Create Instructor
            </a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            @include('common.form-field.text', ['field' => 'name', 'label' => 'Section Title', 'titleFieldform' => true])
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-sm-6">
            @include('common.form-field.number', [
                            'field' => 'num_students',
                            'label' => 'Expected Students per Class',
                            'titleFieldform' => true,
                            'min' => 1,])
        </div>
    </div>

    <hr class="my-3">

    <div class="row mt-3 bg-corporate-color-lighter">
        <div class="col-12">
                <span class="text-primary">
                    To be filled out by the administrator
                </span>
        </div>

        <div class="col-12 col-sm-6 mt-3">
            @if ($course->isLingro())
                @include('common.form-field.text', [
                        'field' => 'lingro_code',
                        'label' => 'Lingro code',
                ])
            @else
                <div class="form-group row">
                    <div class="col-12 text-600">
                        <span class="fw-bold mb-2 ">Lingro Code</span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted small">This course is not Lingro.</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-12 mt-3">

            <label class="mb-1 d-block fw-bold" for="flexCheckDefault">Open access?</label>
            <input type="hidden" name="is_free" value="0"/>
            {{Form::checkbox('is_free', 1, null, ['class' => 'form-check-input'])}}

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


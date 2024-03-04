@extends('layouts.app')

@section('content')

    <div class="card my-3">
        <div class="card-header d-flex justify-content-between bg-text-corporate-color text-white">
            <span class="">
                <i class="fas fa-edit me-1"></i>
                @if ($form->isCreate())
                    Create Experience
                @else
                    Edit Experience
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="sbp-preview">
                <div class="sbp-preview-content">

                    @include('common.form_message_errors')

                    {{ Form::model($form->model(),  [
                   'class' => '',
                   'url'=> $form->action(),
                   'autocomplete' => 'off',
                   'id' =>'experience-form',
                   'files' => true,
                   ]) }}

                    <div class="row">

                        <div class="col-12 col-xl-6">

                            <div class="row">
                                <div class="col-12">
                                    @include('common.form-field.text', ['field' => 'title', 'label' => 'Title'])
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    @include('common.form-field.date', ['field' => 'day', 'label' => 'Day', 'min' => \Carbon\Carbon::now()->toDateString()])
                                </div>

                                <div class="col-sm-4">
                                    @include('common.form-field.time', ['field' => 'start_time', 'label' => 'Start Time (EST)'])
                                </div>

                                <div class="col-sm-4">
                                    @include('common.form-field.time', ['field' => 'end_time', 'label' => 'End Time (EST)'])
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    @include('common.form-field.select', [  'field' => 'code_offer_type_id',
                                                                            'label' => 'Code',
                                                                            'optionsField' => 'codeOfferOptions',
                                                                            'placeholder' => 'None'])
                                </div>
                                <div class="col-sm-4">
                                    @include('common.form-field.select', [  'field' => 'language_id',
                                                                            'label' => 'Language',
                                                                            'optionsField' => 'languageOptions',
                                                                            'placeholder' => 'Select Language'])
                                </div>
                                <div class="col-sm-4">
                                    @include('common.form-field.select', [  'field' => 'level_id',
                                                                            'label' => 'Level',
                                                                            'optionsField' => 'levelOptions',
                                                                            'placeholder' => 'Select Level'])
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class=" col-sm-4">
                                    <div class="form-group row">
                                        <div class="col-12 text-600">
                                            <span class="fw-bold  mb-2  @error('price') text-danger-disabled.. @enderror ">Price</span>
                                        </div>
                                        <div class="col-12">
                                            {{Form::number('price', null, ['class' => 'form-control ', 'min' => 0, 'step' => '0.01'])}}

                                            @error('price')
                                            <span class="custom-invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <span class="custom-invalid-feedback d-none" id="feedback-error-{{'price'}}" role="alert">
                                                <strong></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @include('common.form-field.number', ['field' => 'max_students', 'label' => 'Máx Students'])
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    @include('common.form-field.url', ['field' => 'url_join', 'label' => 'Join url'])
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-xl-6">
                                    <label class="small fw-bold mb-1 @error('university_id') text-danger @enderror" for="university_id">University</label>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            {{Form::select('university_id', $form->optionsField('universityOptions'), null,
                                            [   'class'=>'form-control form-select selectpicker load-child-dropdown-multiple__',
                                                'placeholder' => 'None',
                                                'data-child-dropdown-id' => 'course_id',
                                                'id' => 'university_id',
                                                'data-live-search' => 'true',
                                                'data-child-load-url' => route('post.admin.api.options.course.from_multiple_university'),
                                                'data-child-placeholder' => 'Select a course',
                                                ])}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <label class="small fw-bold mb-1 @error('course_id') text-danger @enderror" for="course_id">Course</label>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            {{Form::select('course_id', $form->optionsField('courseOptions'), null,
                                            [   'class'=>'form-control form-select selectpicker',
                                                'placeholder' => 'None',
                                                'data-child-dropdown-id' => 'course_id',
                                                'data-live-search' => 'true',
                                                'id' => 'course_id',
                                                ])}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4 ">
                                    <label class=" mb-1 d-block fw-bold" for="is_private">Private Experience</label>
                                    <input type="hidden" name="is_private" value="0"/>
                                    {{Form::checkbox('is_private', 1, null, ['class' => 'form-check-input'])}}
                                </div>

                                <div class="col-12 col-sm-4 ">
                                    <label class=" mb-1 d-block fw-bold" for="is_paid_private">Pay for private</label>
                                    <input type="hidden" name="is_paid_private" value="0"/>
                                    {{Form::checkbox('is_paid_private', 1, null, ['class' => 'form-check-input'])}}
                                </div>

                                <div class="col-12 col-sm-4 ">
                                    <label class=" mb-1 d-block fw-bold" for="is_donate_private">Donate for private</label>
                                    <input type="hidden" name="is_donate_private" value="0"/>
                                    {{Form::checkbox('is_donate_private', 1, null, ['class' => 'form-check-input'])}}
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 col-sm-4 col-lg-4">
                                    <label class=" mb-1 d-block fw-bold" for="is_public">Public Experience</label>
                                    <input type="hidden" name="is_public" value="0"/>
                                    {{Form::checkbox('is_public', 1, null, ['class' => 'form-check-input'])}}
                                </div>

                                <div class="col-12 col-sm-4 ">
                                    <label class=" mb-1 d-block fw-bold" for="is_paid_public">Pay for public</label>
                                    <input type="hidden" name="is_paid_public" value="0"/>
                                    {{Form::checkbox('is_paid_public', 1, null, ['class' => 'form-check-input'])}}
                                </div>

                                <div class="col-12 col-sm-4 ">
                                    <label class=" mb-1 d-block fw-bold" for="is_donate_public">Donate for public</label>
                                    <input type="hidden" name="is_donate_public" value="0"/>
                                    {{Form::checkbox('is_donate_public', 1, null, ['class' => 'form-check-input'])}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    @include('common.form-field.select', [  'field' => 'coach_id',
                                                                            'label' => 'Coach',
                                                                            'optionsField' => 'coachOptions',
                                                                            'placeholder' => 'Select Coach'])
                                </div>
                                <div class="col-sm-4">
                                    @include('common.form-field.text', ['field' => 'coach_name', 'label' => 'Coach Name'])
                                </div>
                                <div class=" col-sm-4">
                                    @include('common.form-field.text', ['field' => 'coach_lastname', 'label' => 'Coach Last Name'])
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            @include('admin.experience.form.files')

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-12">
                                    @include('common.form-field.textarea', ['field' => 'description',
                                                                            'label' => 'Description',
                                                                            'id' => 'ckeditor',
                                                                            'rows' => 5,
                                                                            'ckEditor' => 'ckeditor-basic'])


                                </div>
                            </div>

                        <?php /*
                            @include('admin.experice.form.admin.experience.form.description')
                            */?>

                            <div class="row mt-5">
                                <div class="col-12 text-left">
                                    <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                        {{$form->isCreate() ? 'Create' : 'Update'}}
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>

                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

@endsection

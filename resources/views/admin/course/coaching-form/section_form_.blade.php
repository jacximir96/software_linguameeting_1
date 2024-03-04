{{ Form::model($sectionForm->model(),  [
                           'class' => 'coaching-section-form',
                           'url'=> $sectionForm->action(),
                           'autocomplete' => 'off',
                           'id' =>'coaching-section-form-'.$sectionItem->id
                           ]) }}


<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.select', [  'field' => 'instructor_id',
                                                 'label' => 'Instructor',
                                                 'form' => $sectionForm,
                                                 'optionsField' => 'instructorOptions',
                                                 'placeholder' => 'Select Instructor'])
    </div>
    <div class="col-12">
        <a  href="{{route('get.common.course.course_coordinator.create', $courseForm)}}"
            class="small open-modal"
            data-modal-reload="yes"

            data-reload-type="element"
            data-reload-element=".body-{{$sectionItem->id}}"
            data-reload-url="{{route('get.admin.course.section.api.load_form', $sectionItem)}}"
            data-modal-title='Create Instructor'>
            <i class="fa fa-plus"></i> Create Instructor
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        @include('common.form-field.text', ['field' => 'name', 'label' => 'Section Title', 'required' => true,  'normalText' => true])
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-sm-6">
        @include('common.form-field.number', ['field' => 'num_students', 'label' => 'Expected Students per Class', 'min' => 1, 'required' => true,  'normalText' => true])
    </div>
</div>

<hr>

<div class="row mt-3">
    <div class="col-lg-6">
        @include('common.form-field.text', ['field' => 'lingro_code', 'label' => 'Lingro code'])
    </div>

    <div class="col-lg-3">

        <label class="small mb-1 d-block fw-bold" for="flexCheckDefault">Open access?</label>
        <input type="hidden" name="is_free" value="0"/>
        {{Form::checkbox('is_free', 1, null, ['class' => 'form-check-input'])}}

    </div>
</div>


<div class="row mt-3">
    <div class="col-12 text-left d-flex justify-content-between">
        <button class="btn btn-primary btn-sm btn-bold px-4 btn-save-section"
                data-form-id="coaching-section-form-{{$sectionItem->id}}"
                type="button">
            Save Section
        </button>

        <a href="#"
           onclick="return confirm('Are you sure to remove this section?');"
           class="btn btn-danger bg-corporate-danger btn-sm btn-bold px-4">
            Delete Section
        </a>
    </div>
</div>
{{Form::close()}}

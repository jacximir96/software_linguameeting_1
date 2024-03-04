<h2 class="accordion-header" id="heading{{$sectionEditable->sectionId()}}">
    <button class="accordion-button collapsed small-font-size-rem-1-1"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapse{{$sectionEditable->sectionId()}}"
            aria-expanded="true"
            aria-controls="collapse{{$sectionEditable->sectionId()}}">
        {{$sectionEditable->section()->name}} / {{$sectionEditable->section()->instructor->writeFullName() ?? 'Without instructor assigned'}}
    </button>
</h2>
<div id="collapse{{$sectionEditable->sectionId()}}" class="accordion-collapse collapse "
     aria-labelledby="heading{{$sectionEditable->sectionId()}}"
     data-bs-parent="#accordionSection">
    <div class="accordion-body shadow p-2 py-md-2 px-md-3 background-field body-{{$sectionEditable->sectionId()}}">

        <div class="row">

            {{ Form::model($sectionEditable->sectionForm()->model(),  [
                       'class' => 'coaching-section-form',
                       'url'=> $sectionEditable->sectionForm()->action(),
                       'autocomplete' => 'off',
                       'id' =>'coaching-section-form-'.$sectionEditable->section()->id
                       ]) }}


            <div class="row mt-3">
                <div class="col-12 col-xl-6">
                    @include('common.form-field.text', ['field' => 'name', 'label' => 'Name', 'required' => true,])
                </div>

                <div class="col-12 col-md-8 col-lg-6 col-xl-4 mt-3 mt-xl-0">
                    @include('common.form-field.number', ['field' => 'num_students', 'label' => 'Expected Students per Class', 'min' => 1, 'required' => true])
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-12 col-lg-6">
                    @include('common.form-field.select', [  'field' => 'instructor_id',
                                                             'label' => 'Instructor',
                                                             'form' => $sectionEditable->sectionForm(),
                                                             'optionsField' => 'instructorOptions',
                                                             'placeholder' => 'Select Instructor',
                                                             ])

                    <a href="{{route('get.common.course.instructor.simple.create', [$course->university_id, $course->language_id])}}"
                       class="small open-modal d-block mt-2 text-success text-decoration-underline fw-bold"
                       data-modal-reload="yes"

                       data-reload-type="element"
                       data-reload-element="#accordion-item-{{$sectionEditable->section()->id}}"
                       data-reload-url="{{route('get.common.course.section.api.load_section', $sectionEditable->sectionId())}}?sectionToExpand={{$sectionEditable->sectionId()}}"
                       data-modal-title='Create Instructor'>
                        <i class="fa fa-plus"></i> Create Instructor
                    </a>
                </div>

                <div class="col-12 col-lg-6 mt-3 mt-lg-0">

                    <div class="form-group row">

                        <div class="col-12 text-600">
                            <span class="mb-2 fw-bold">Instructor Assistant</span>
                        </div>


                            <div class="col-12">

                                @if ($sectionInformationForm->hasTeachingAssistant())
                                    @include('common.form-field.select', [  'field' => 'teaching_assistant_id',
                                                                 'label' => '',
                                                                 'form' => $sectionInformationForm,
                                                                 'optionsField' => 'optionsTeachingAssistants',
                                                                 'placeholder' => 'Select Teaching Assistant',
                                                                 'normalText' => true])
                                    <span class="custom-invalid-feedback d-none" id="feedback-error-teaching_assistant_id" role="alert">
                                        <strong></strong>
                                    </span>

                                @endif

                                <a href="{{route('get.common.course.instructor.teching_assistant.section.create', $sectionEditable->section())}}"
                                   class="small open-modal d-block mt-2 text-success text-decoration-underline fw-bold"

                                   data-modal-reload="yes"
                                   data-reload-type="parent"
                                   data-modal-title='Create Instructor Assistant'>
                                    <i class="fa fa-plus"></i> Create Instructor Assistant
                                </a>
                            </div>


                        <div class="col-12 mt-2 small">
                            @if ($sectionEditable->section()->teachingAssistant->count())
                                <span class="text-decoration-underline">Instructors assistants assigned to this section:</span>
                                <ul class="mt-2">
                                    @foreach ($sectionEditable->section()->teachingAssistant as $teachingAssistant)
                                        <li>
                                            <span>{{$teachingAssistant->teacher->writeFullName()}}</span>
                                            <a href="{{route('get.common.course.instructor.teching_assistant.section.delete', $teachingAssistant->hashId())}}"
                                               class="ms-3 delete-teaching-assistant-from-section"
                                               data-reload-element="#accordion-item-{{$sectionEditable->section()->id}}"
                                               data-reload-url="{{route('get.common.course.section.api.load_section', $sectionEditable->section()->id)}}"
                                               title="Remove teaching assistant from section">
                                                <i class="fa fa-times text-danger"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            @else
                                <span class="subtitle-color small">No teacher’s assistant assigned.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-3 pb-3">
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12 mb-3">
                    <span class="text-primary fw-bold">
                         To be filled out by the administrator
                    </span>
                </div>
                <div class="col-md-6 col-xl-4">
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
                                <span class="subtitle-color small">This course is not Lingro.</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 col-lg-3 mt-3 mt-md-0">

                    <label class="small mb-1 d-block fw-bold" for="flexCheckDefault">Open access?</label>
                    <input type="hidden" name="is_free" value="0"/>
                    {{Form::checkbox('is_free', 1, null, ['class' => 'form-check-input'])}}

                </div>
            </div>


            <div class="row mt-5">
                <div class="col-12 text-left d-flex justify-content-between">

                    <a href="{{route('get.common.course.section.delete', $sectionEditable->section())}}"
                       onclick="return confirm('Are you sure to remove this section?');"
                       class="btn btn-danger bg-corporate-danger btn-sm btn-bold px-4">
                        <span class="d-block d-md-none">Delete</span>
                        <span class="d-none d-md-block">Delete Section</span>
                    </a>

                    <button class="btn btn-primary btn-sm btn-bold px-4 btn-save-section"
                            data-form-id="coaching-section-form-{{$sectionEditable->section()->id}}"
                            data-reload-element="#accordion-item-{{$sectionEditable->section()->id}}"
                            data-reload-url="{{route('get.common.course.section.api.load_section', $sectionEditable->sectionId())}}"
                            type="button">
                        <span class="d-block d-md-none">Save</span>
                        <span class="d-none d-md-block">Save Section</span>
                    </button>
                </div>
            </div>
            {{Form::close()}}


        </div>
    </div>
</div>

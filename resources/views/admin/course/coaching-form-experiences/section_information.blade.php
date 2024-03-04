@extends('layouts.app')

@section('content')


    <div class="card">

        @include('admin.course.coaching-form.header_card')

        <div class="card-body container">

            @include('admin.course.coaching-form-experiences.wizard_step', ['step' => 2])

            @include('common.form_message_errors')

            <div class="row mt-5">

                <div class="col-md-8">

                    {{ Form::model($sectionInformationForm->model(),  [
                       'class' => '',
                       'url'=> $sectionInformationForm->action(),
                       'autocomplete' => 'off',
                       'id' =>'section_information'
                       ]) }}


                        @include('admin.course.coaching-form.title', [
                            'title' => 'Section Information',
                            'showPricing' => false
                        ])

                        @if ( ! $allowsFullEdition)
                            @include('admin.course.coaching-form.warning_no_full_edition')
                        @endif

                        @include('admin.course.coaching-form.section-information.info_coordinator')

                    {{Form::close()}}


                    <div class="row mt-5">
                        <div class="col-12">
                            <span class="title-field-form "><i class="fa fa-chalkboard-teacher fa-fw"></i> Sections</span>

                            <a href="{{route('get.common.course.section.create', $course)}}"
                               class="small open-modal text-success text-decoration-underline fw-bold d-block d-sm-inline-block ms-0 ms-sm-5 mt-2 mt-xl-0"
                               title="Create Section"

                               data-modal-reload="yes"
                               data-reload-type="parent"
                               data-modal-title='Create Section'>
                                <i class="fa fa-plus"></i> Create Section
                            </a>
                        </div>

                        @error('number_section')
                        <span class="custom-invalid-feedback block border rounded p-3 mt-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row mt-2">

                        <div class="col-12">

                            <div class="accordion" id="accordionSection">

                                @foreach ($viewData->sectionsEditable() as $sectionEditable)

                                    <div class="accordion-item" id="accordion-item-{{$sectionEditable->sectionId()}}">

                                    @include('admin.course.coaching-form.section-information.section', [
                                        'sectionEditable' => $sectionEditable,
                                        'canFillLingroCode' => $course->isLingro()
                                    ])
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">

                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{$sectionInformationForm->backStepRoute()}}"
                               title="Config Academic Dates"
                               class="btn  btn-bold px-4 bg-text-corporate-color text-white" >
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            <button class="btn btn-bold px-4 bg-text-corporate-color text-white" id="btn_to_course_assignment" type="button">
                                Next <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>



                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0 ">
                    <div class="sticky-top bg-text-corporate-color text-white rounded p-2">
                        @include('admin.course.coaching-form-experiences.course_summary_sidebar')
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery.ajaxSetup({cache: false});

        });
    </script>

@endsection

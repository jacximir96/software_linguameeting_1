@extends('layouts.app')

@section('content')


    <div class="card">

        @include('admin.course.coaching-form.header_card')

        <div class="card-body container">

            @include('admin.course.coaching-form.wizard_step', ['step' => 5])

            @include('common.form_message_errors')

            <div class="row mt-5">

                <div class="col-md-8">

                    <div class="row">
                        <div class="col-12 d-flex justify-content-between shadow-sm pb-1" style="border-bottom:1px solid #39b4b3d9">
                            <h4 class="fw-bold title-step "  >
                                Course Assignment
                            </h4>

                            <a href="{{route('get.admin.course.coaching_form.course_summary', $course->id)}}"
                               class="btn btn-bold bg-text-corporate-color text-white">
                                Skip <i class="fa fa-arrow-right d-none d-sm-inline-block"></i>
                            </a>
                        </div>

                    </div>

                    @if ( ! $allowsFullEdition)
                        @include('admin.course.coaching-form.warning_no_full_edition')
                    @endif

                    <div class="row  mt-0 ">
                        <div class="col-12">
                            @include('admin.course.coaching-form.course-assignment.instructions')
                        </div>
                    </div>
                    @if ( ! $isSmallGroup)
                        {{ Form::model($viewData->formForAll()->model(),  [
                           'class' => '',
                           'url'=> $viewData->formForAll()->action(),
                           'autocomplete' => 'off',
                           'id' =>'form-for-all-sections'
                           ]) }}
                            <input type="hidden" id="section-id-for-all-sections" name="section-id-for-all-sections" value="" />

                        {{Form::close()}}
                    @endif

                    @if ($course->section->count())


                        {{ Form::model($viewData->form()->model(),  [
                           'class' => '',
                           'url'=> $viewData->form()->action(),
                           'autocomplete' => 'off',
                           'id' =>'one-on-one-guide-form'
                           ]) }}

                        @if ($isSmallGroup)

                            @include('admin.course.coaching-form.course-assignment.small_group')

                        @else

                            @include('admin.course.coaching-form.course-assignment.one_on_one')

                        @endif

                    @else
                        <div class="row mt-4 mx-auto">
                            <div class="col-12 alert alert-warning">
                                <span class="h">Es necesario tener al menos una sección para poder asignar documentación al curso.</span>
                            </div>
                        </div>

                    @endif

                    <div class="row mt-4">

                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{route('get.admin.course.coaching_form.section_information', $course->id)}}"
                               title="Config Academic Dates"
                               class="btn  btn-bold px-4 bg-text-corporate-color text-white" >
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            @if ($course->section->count())

                                <button type="submit"
                                        class="btn btn-bold px-4 bg-text-corporate-color text-white">
                                    Next <i class="fa fa-arrow-right"></i>
                                </button>
                            @else
                                <a href="{{route('get.admin.course.coaching_form.course_summary', $course->id)}}"
                                   class="btn btn-bold px-4 bg-text-corporate-color text-white">
                                    Next <i class="fa fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                @if ($course->section->count())
                    {{Form::close()}}
                @endif

                <div class="col-md-4 mt-3 mt-md-0 ">
                    <div class="sticky-top bg-text-corporate-color text-white rounded p-2">
                        @include('admin.course.coaching-form.course_summary_sidebar')
                    </div>
                </div>
            </div>

        </div>
        <input type="hidden" name="max_size_file_in_kb" id="max-size-file-in-kb" value="{{$maxFileSizeInKB}}"/>
    </div>

    <script>
        jQuery(document).ready(function () {

            jQuery.ajaxSetup({cache: false});


            jQuery(document).on('click', '.btn-apply-for-all', function (event) {

                event.preventDefault()

                var sectionId = jQuery(this).data('section-id')
                jQuery('#section-id-for-all-sections').val(sectionId)

                var formId ='#form-for-all-sections'

                //empty formData
                var formData = new FormData(); // Currently empty
                formData.append('section_id', sectionId);

                //filled with form fields
                var $inputs = jQuery('#one-on-one-guide-form :input')

                $inputs.each(function() {

                    if ($(this).is(':checkbox') && !$(this).is(':checked')) {
                        // Si es un checkbox y no está marcado, no lo agregamos al FormData
                        return;
                    }
                    else if ($(this).is(':radio') && $(this).attr('name') == 'guide_type' && !$(this).is(':checked')) {
                        // Si es un radio button y no está seleccionado, no lo agregamos al FormData
                        return;
                    }

                    formData.append(this.name, $(this).val());
                });


                jQuery.ajax({
                    url: jQuery(formId).attr('action'),
                    type:"POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    context: this,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(response){

                        window.location.replace(response.redirect_to);

                    },
                    error: function(response, textStatus, xhr) {

                        if (response.status != 422){

                            $.notify("An error occurred while updating the section. Check field form.", {
                                className: "error",
                                position: "top-center",
                                showDuration: 400,
                                hideDuration: 400,
                                autoHideDelay: 2000,
                            });
                        }
                    },
                    statusCode: {

                        422: function (data){
                            jQuery.each(data.responseJSON.errors, function(fieldName, messages) {
                                show422Feedback(fieldName, messages)
                            })
                        }
                    }
                });
            });

        });
    </script>

@endsection

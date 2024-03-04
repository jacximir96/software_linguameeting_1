@extends('layouts.app_modal')

@section('content')



    @include('common.form_message_errors')


    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                @if (isset($coachingWeek))
                    <p class="fw-bold border-bottom d-flex justify-content-between">
                        <span class="d-inline-block">Assignment for Session: {{$coachingWeek->session_order}}</span>
                        <span class="d-inline-block subtitle-color ">{{$sessionDescription}}</span>
                    </p>
                @else
                    <p class="fw-bold border-bottom">
                        <span class="d-inline-block">Assignment for Session: {{$sessionDescription}}</span>
                    </p>
                @endif
            </div>
        </div>

        {{ Form::model($form->model(),  [
              'class' => '',
              'url'=> $form->action(),
              'autocomplete' => 'off',
              'files' => true,
              'id' => 'form-week-assignment-'.$formId
              ]) }}
        <div class="row mt-2">
            <div class="col-12">
                <span class="d-block fw-bold">Activity Name</span>
                {{Form::text('activity_name', null, ['class' => 'form-control with-placeholder', 'id' => 'name', 'placeholder' => $form->namePlaceholder($section)])}}
            </div>
            <div class="col-12 mt-3">
                <span class="d-block fw-bold">Content</span>
                {{Form::textarea('activity_description', null, [
                      'class' => 'form-control with-placeholder',
                      'rows' => 4,
                      'id'=> 'activity-description',
                      'placeholder' => $form->descriptionPlaceholder($section),
                  ])}}
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                or <span class="fw-bold">Choose/Upload</span> <span class="fw-bold">file</span>
                {{Form::file('file', ['class' => 'form-control-xs file-assignment', 'data-session-id' => 'all'])}}
                <span class="subtitle-color small ">Max size file {{config('linguameeting.files.max_upload_size_in_KB')/1024}} MB.</span>
                <div class="mt-1">
                    <span class="d-inline-block small">Need a template?</span>
                        <a href="#"
                           data-bs-toggle="modal" data-bs-target="#examples-new-assignments-guides"
                           class="text-corporate-color-lighter text-decoration-underline fw-bold small">LinguaMeeting Assignment Example</a>

                    <span class="subtitle-color small">and select one for each session.</span>

                    @include('common.modal_info', [
                               'modalId' => 'examples-new-assignments-guides',
                               'modalTitle' => 'LinguaMeeting Assignment Example',
                               'size' => 'modal-lg',
                               'path' => 'admin.course.coaching-form.course-assignment.templates',
                               'templates' => $templates
                           ])
                </div>

                <span
                    id="feedback-error-feedback-file-session-all"
                    class="feedback-file-session-all feedback-file-session text-danger small fst-italic d-block"><strong></strong></span>

                @error('file')
                <span class="custom-invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            @if ($assignment)
                @if ($assignment->file)
                    <div class="col-12 mt-3">
                        <p class="ms-3">
                            <span class="fw-bold me-3">This session already has a file:</span>

                            <a href="{{route('get.common.course.assignment.file.download', $assignment->file->id)}}"
                               class="me-5">
                                <i class="fa fa-download"></i> Download {{$assignment->file->original_name}}
                            </a>

                            <a href="{{route('get.common.course.assignment.file.delete', $assignment->file->id)}}"
                               onclick="return confirm('Are you sure to remove this file?');"
                               class="">
                                <i class="fa fa-times text-danger"></i> Delete
                            </a>
                        </p>
                    </div>
                @endif
            @endif
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <span class="d-inline-block fw-bold">Private note to the coach (optional)</span>
                <a href="#"
                   class="fst-italic text-decoration-underline d-inline-block"
                   data-bs-toggle="modal"
                   data-bs-target="#private-note-coach">
                    <i class="fa fa-info-circle text-dark"></i>
                </a>
                @include('common.modal_info', [
                    'modalId' => 'private-note-coach',
                    'modalTitle' => 'Private note to the coach',
                    'path' => 'admin.course.coaching-form.info_note_coach'
                ])
            </div>
            <div class="col-12">
                {{Form::textarea('coach_note', null, [
                      'class' => 'form-control ',
                      'rows' => 2,
                      'id'=> 'coach-note'
                  ])}}
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-12 text-end d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-sm bg-light me-2" id="button-clean-assignment" style="border:1px solid #ccc">Clean</button>
                </div>
                <div>
                    <button type="submit" name="action" value="save-current-session" class="btn btn-sm bg-corporate-color text-white me-2">Save</button>
                    <button type="submit" name="action" value="save-all-sessions" class="btn btn-sm bg-corporate-color-light" style="border-color:#39b4b3">Save for <span class="text-decoration-underline">all</span>
                        sessions
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="max_size_file_in_kb" id="max-size-file-in-kb" value="{{config('linguameeting.files.max_upload_size_in_KB')}}"/>

        {{Form::close()}}
    </div>

@endsection

@extends('layouts.app_modal')

@section('content')


    <div class="sbp-preview">
        <div class="sbp-preview-content">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
               'class' => '',
               'url'=> $form->action(),
               'autocomplete' => 'off',
               'id' =>'coach-help-form',
               'files' => true,
           ]) }}

            <div class="row">

                <div class="col-12">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <div class="col-12 text-600">
                                    <span class="fw-bold  mb-2  @error('participant_id[]') text-danger-disabled @enderror ">Participants</span>
                                </div>
                                <div class="col-12">
                                    {{Form::select('participant_id[]', $form->optionsField('recipientOptions'), null,
                                        [   'class'=>'form-input-recipient form-control form-select select-2 '.($errors->has('participant_id') ? ' is-invalid ' : null),
                                            'required' => 'required',
                                            'data-search-url' => route('post.admin.api.users.search.autocomplete'),
                                            'multiple' => true
                                            ])}}

                                    @error('participant_id')
                                        <span class="custom-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            @include('common.form-field.text', ['field' => 'subject', 'label' => 'Subject'])
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="mb-3 col-12">
                            @include('common.form-field.textarea', ['field' => 'content',
                                                                    'label' => 'Body',
                                                                    'id' => 'ckeditor',
                                                                    'ckEditorHeight' => '200px',
                                                                    'ckEditor' => 'ckeditor-basic'])
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-6">
                            {{Form::file('thread_file[]', ['class' => 'form-control-xs file-assignment', 'data-session-id' => 'all', 'multiple' => true])}}
                            <span class="subtitle-color small d-block">Max size file {{config('linguameeting.files.max_upload_size_in_KB')/1024}} MB.</span>

                            @error('thread_file')
                                <span class="custom-invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if ($form->isEdit())
                            @if ($experienceFiles->hasVocabularyFile())
                                <div class="col-6">
                                    <a href="{{route('get.experience.file.download', $experienceFiles->vocabularyFile()->id )}}"
                                       title="Download {{$experienceFiles->vocabularyFile()->original_name}}"
                                       class="me-3">
                                        <i class="fa fa-download"></i> Download Vocabulary
                                    </a>
                                    <a href="{{route('get.admin.experience.file.delete', $experienceFiles->vocabularyFile()->id)}}"
                                       onclick="return confirm('Are you sure to remove this file?');"
                                       class="">
                                        <i class="fa fa-times text-danger"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 text-left">
                            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                {{$form->isCreate() ? 'Send' : 'Update'}}
                            </button>
                        </div>
                    </div>


                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
@endsection

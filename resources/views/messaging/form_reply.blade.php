{{ Form::model($replyForm->model(),  [
       'class' => '',
       'url'=> $replyForm->action(),
       'autocomplete' => 'off',
       'id' =>'reply-form',
       'files' => true,
   ]) }}
<div class="row mt-0">
    <div class="col-12">
        @include('common.form-field.textarea', ['field' => 'content',
                                                'label' => '',
                                                'id' => 'ckeditor',
                                                'ckEditorHeight' => '150px',
                                                'ckEditor' => 'ckeditor-basic'])
    </div>
</div>

<div class="row mt-3">

    <div class="col-12">
        {{Form::file('thread_file[]', ['class' => 'form-control-xs file-assignment', 'data-session-id' => 'all', 'multiple' => true])}}
        <span class="subtitle-color small d-block">Max size file {{config('linguameeting.files.max_upload_size_in_KB')/1024}} MB.</span>

        @error('thread_file')
        <span class="custom-invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
</div>

<div class="row mt-5">
    <div class="col-12 text-left">
        <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
            Reply
        </button>
    </div>
</div>

{{Form::close()}}

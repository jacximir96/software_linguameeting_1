<div class="row mt-3">
    <div class="col-12">
        <span class="fw-bold  mb-2  @error('vocabulary_file') text-danger-disabled.. @enderror ">Vocabulary</span>
    </div>
    <div class="col-12">

        <div class="row">

            <div class="col-6">
                {{Form::file('vocabulary_file', ['class' => 'form-control-xs file-assignment', 'data-session-id' => 'all'])}}
                <span class="subtitle-color small d-block">Max size file {{config('linguameeting.files.max_upload_size_in_KB')/1024}} MB.</span>

                @error('vocabulary_file')
                <span class="custom-invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

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
        </div>
    </div>
</div>

<div class="row mt-3">

    <div class="col-sm-6">
        @include('admin.experience.form.banner_file', ['order' => 1])
    </div>

    <div class="col-sm-6">
        @include('admin.experience.form.banner_file', ['order' => 2])
    </div>
</div>

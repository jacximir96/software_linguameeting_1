<div class="form-group row">
    <div class="col-12 text-600">
        <span class="fw-bold  mb-2  @error('vocabulary_file') text-danger-disabled.. @enderror ">Banner {{$order}}</span>
    </div>
    <div class="col-12">
        {{Form::file('banner_'.$order, [])}}
        <span class="subtitle-color small d-block ">Max size file {{config('linguameeting.files.max_upload_size_in_KB')/1024}} MB.</span>

        @error('banner_'.$order)
            <span class="custom-invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    @if ($experienceFiles->hasBannerFile($order))
        <div class="col-12 mt-1">
            <a href="{{route('get.experience.file.download', $experienceFiles->bannerFile($order)->id )}}"
               title="Download {{$experienceFiles->bannerFile($order)->original_name}}"
               class="me-3">
                <i class="fa fa-download"></i> Download banner
            </a>
            <a href="{{route('get.admin.experience.file.delete', $experienceFiles->bannerFile($order)->id)}}"
               onclick="return confirm('Are you sure to remove this file?');"
               class="">
                <i class="fa fa-times text-danger"></i>
            </a>
        </div>
    @endif
</div>

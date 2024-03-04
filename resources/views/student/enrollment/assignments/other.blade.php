@if ($assignment->file)
    <div class="row mt-3">
        <div class="col-12  ">
            <span class="d-inline-block me-2 fw-bold">Custom Assignment:</span>

            <p class="m-0 text-muted d-inline-block text-corporate-dark-color">
                <a href="{{route('get.common.course.assignment.file.download', $assignment->file->hashId())}}"
                   class="me-5">
                    {{$assignment->file->original_name}}
                </a>
            </p>
        </div>
    </div>
@endif

@if ($assignment->hasActivityDescription())
    <div class="row mt-1">
        <div class="col-12  ">
            <span class="d-inline-block me-2 fw-bold">Activity Name:</span>

            <p class="m-0 text-muted d-inline-block text-corporate-dark-color">
                {!! $assignment->activity_name ?? '-' !!}
            </p>
        </div>
    </div>
@endif


@if ($assignment->hasActivityDescription())
    <div class="row mt-1">
        <div class="col-12">

            <p class="m-0  d-inline-block ">
                <span class="d-inline-block me-2 fw-bold text-dark">Content:</span>
                {{ $assignment->activity_description ?? '-' }}
            </p>
        </div>
    </div>
@endif

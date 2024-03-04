<div class="row mt-2">
    <div class="col-12 d-flex justify-content-between">
        @if ($assignment->chapter)
            <span class="d-inline-block me-4 text-corporate-dark-color">
                {{$assignment->chapter->chapter->name}}
            </span>

            @php $file = $assignment->chapter->chapter->file @endphp
            @if ($file)
                <a href="{{route('get.common.conversation_guide.chapter.file.download', $file->id)}}"
                   title="Download {{$file->original_name}}">
                    <i class="fa fa-download"></i> Download Chapter
                </a>
            @else
                -
            @endif

        @else
            <span class="text-corporate-danger ">No guide selected</span>
        @endif
    </div>
</div>

<div class="row mt-2">
    <div class="col-12 d-flex justify-content-between">
        <span class="d-inline-block me-2">Custom Assignment:</span>
        @if ($assignment->file)
            <a href="{{route('get.common.course.assignment.file.download', $assignment->file->id)}}"
               title="{{$assignment->file->original_name}}"
               class="">
                <i class="fa fa-download"></i> Download Custom Assignment
            </a>
        @else
            <span class="text-corporate-danger ">Not selected</span>
        @endif
    </div>
</div>

<div class="row mt-2">
    <div class="col-12  ">
        <span class="d-inline-block me-2">Activity Name:</span>
        <p class="m-0 text-muted d-inline-block text-corporate-dark-color">
            @if ($assignment->hasActivityDescription())
                {!! $assignment->activity_name ?? '-' !!}
            @else
                -
            @endif
        </p>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <span class="d-block">Content:</span>
        <p class="m-0 text-corporate-dark-color long-text">
            @if ($assignment->hasActivityDescription())
                {{ $assignment->activity_description ?? '-' }}
            @else
                -
            @endif
        </p>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12  ">
        <span class="d-block">Coach Note:</span>
        <p class="m-0 text-corporate-dark-color long-text">
            @if ($assignment->hasCoachNote())
                {{ $assignment->coach_note ?? '-' }}
            @else
                -
            @endif
        </p>
    </div>
</div>


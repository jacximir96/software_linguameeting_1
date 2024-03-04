<div class="row">
    <div class="col-3">
        @if ($assignment->isWeek())
            <span class="fw-bold">Session:</span> <span class="text-corporate-dark-color fw-bold ">{{$assignment->week->session_order}}</span>
        @else
            <span class="fw-bold">Session {{$assignment->session_order}}</span>
        @endif
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 ">
        <span class="fw-bold me-2">Guide:</span>
        @if ($assignment->chapter)
            <span class="d-inline-block me-4 text-corporate-dark-color fw-bold">
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

@if ($assignment->file)
<div class="row mt-3">
    <div class="col-12  ">
        <span class="d-inline-block me-2 fw-bold">Custom Assignment:</span>

        <p class="m-0 text-muted d-inline-block text-corporate-dark-color">
            <a href="{{route('get.common.course.assignment.file.download', $assignment->file->id)}}"
               class="me-5">
                <i class="fa fa-download"></i> Download {{$assignment->file->original_name}}
            </a>
        </p>
    </div>
</div>
@endif

@if ($assignment->hasActivityDescription())
<div class="row mt-3">
    <div class="col-12  ">
        <span class="d-inline-block me-2 fw-bold">Activity Name:</span>

        <p class="m-0 text-muted d-inline-block text-corporate-dark-color">
            {!! $assignment->activity_name ?? '-' !!}
        </p>
    </div>
</div>
@endif


@if ($assignment->hasActivityDescription())
<div class="row mt-3">
    <div class="col-12">
        <span class="d-inline-block me-2 fw-bold">Content:</span>
        <p class="m-0 text-muted d-inline-block text-corporate-dark-color">
            {{ $assignment->activity_description ?? '-' }}
        </p>
    </div>
</div>
@endif

@if ($assignment->hasCoachNote())
<div class="row mt-3">
    <div class="col-12  ">
        <span class="d-inline-block me-2 fw-bold">Coach Note:</span>
        <p class="m-0 d-inline-block text-corporate-dark-color">
            {{ $assignment->coach_note ?? '-' }}
        </p>
    </div>
</div>
@endif

@if ($assignment->chapter)
    @php $file = $assignment->chapter->chapter->file @endphp
    @if ($file)
        <a href="{{route('get.student.enrollment.assignment.chapter.download', $file->hashId())}}"
           title="Download {{$file->original_name}}">
            {{$assignment->chapter->chapter->name}}
        </a>
    @else
        <span class="fw-bold">
            {{$assignment->chapter->chapter->name}}
        </span >
    @endif

@else
    <span class="text-corporate-danger ">No guide selected</span>
@endif



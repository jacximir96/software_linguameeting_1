@if ($assignment->isWeek())
    Session:{{$assignment->week->session_order}}
@else
    Session {{$assignment->session_order}}
@endif
@if ($assignment->chapter)
@php $file = $assignment->chapter->chapter->file @endphp
@if ($file)
Chapter: <a href="{{route('get.common.conversation_guide.chapter.file.download', $file->id)}}">{{$assignment->chapter->chapter->name}}</a>
@else
Chapter: -
@endif
@else
No guide selected
@endif
@if ($assignment->file)
Custom Assignment: <a href="{{route('get.common.course.assignment.file.download', $assignment->file->id)}}">{{$assignment->file->original_name}}</a>
@else
Custom Assignment: -
@endif

@if ($assignment->hasActivityDescription())
Activity Name: {!! $assignment->activity_name ?? '-' !!}
@else
Activity Name: -
@endif

@if ($assignment->hasActivityDescription())
    Content: {{ $assignment->activity_description ?? '-' }}
@else
    Content: -
@endif

@if ($assignment->hasCoachNote())
    Coach Note: {{ $assignment->coach_note ?? '-' }}
@else
    Coach Note: -
@endif

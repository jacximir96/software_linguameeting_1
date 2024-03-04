@if ($section->assignment->count())

    @php $statusSection = $section->statusAssignment() @endphp

    @if ($statusSection->isCompleted())
        <span class="fw-bold text-success small d-inline-block me-2">
            Completed
        </span>
    @else
        <span class="text-danger small d-inline-block me-2" title="{{$statusSection->completed()}} sessions completed out of {{$statusSection->totalSessions()}}">
            {{$statusSection->completed()}} of {{$statusSection->totalSessions()}} completed
        </span>
    @endif

    <a href="#"
       class="text-decoration-underline small"
       data-bs-toggle="modal"
       data-bs-target="#modal-assignments-{{$section->id}}">
        Review
    </a>

    @include('common.modal_info', [
        'modalId' => 'modal-assignments-'.$section->id,
        'modalTitle' => 'Assignments in Section '.$section->name,
        'size' => 'modal-lg',
        'path' => 'admin.course.coaching-form.course-summary.assignments',
        'section' => $section,
    ])
@else
    <span class="fst-italic text-muted small">No assignments</span>
@endif

<a href="{{route('get.admin.course.coaching_form.course_assignment', $section->course->id)}}?sectionToExpand={{$section->id}}"
   title="Edit section assignments"
   target="_blank"
   class="ms-2 small">
    <i class="fa fa-edit"></i>
</a>

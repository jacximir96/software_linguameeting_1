<div class="col-12 py-2 mb-2 rounded" style="background-color: rgba(53, 180, 180,0.2)">
    <div class="row">
        <div class="col-12 text-start">
            <span class="text-corporate-dark-color fw-bold ms-2 me-3"><i class="fa fa-fw fa-chalkboard-teacher me-2"></i> Sections</span>
            @if($course->isActive())
            <a href="{{route('get.admin.course.coaching_form.section_information', $course->id)}}" class="small" title="Edit sections">
                <i class="fa fa-edit"></i>
            </a>
            @endif
        </div>
    </div>
</div>

@foreach ($sections as $section)
    <div class="col-12 mb-3 ps-2 small">

        <div class="row">
            <div class="col-12">
                <span class="fw-bold fst-italic">Section {{$loop->iteration}}</span>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Name</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <span class="fst-italic">{{$section->name}}</span>
                <a href="{{route('get.common.course.section.file.instructions.download', $section)}}"
                   title="Download instructions"
                   class="small d-block">
                    <i class="fa fa-download"></i> Instructions
                </a>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Instructor</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <span class="fst-italic">{{$section->instructor->writeFullName()}}</span>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Class ID</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <span class="fst-italic">{{$section->code}}</span>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Assignments</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                @if ($section->assignment->count())

                    @php $statusSection = $section->statusAssignment() @endphp
                    @if ($statusSection->isCompleted())
                        <span class="fw-bold text-success small d-block">
                                Completed
                            </span>
                    @else
                        <span class="text-danger small d-block" title="{{$statusSection->completed()}} sessions completed out of {{$statusSection->totalSessions()}}">
                            {{$statusSection->completed()}} of {{$statusSection->totalSessions()}} completed
                        </span>
                    @endif

                    @if($course->isActive())
                    <a href="#"
                       class="text-decoration-underline small"
                       data-bs-toggle="modal"
                       data-bs-target="#modal-assignments-{{$section->id}}">
                        Review
                    </a>
                    @endif

                    @include('common.modal_info', [
                        'modalId' => 'modal-assignments-'.$section->id,
                        'modalTitle' => 'Assignments in Section: '.$section->name,
                        'size' => 'modal-lg',
                        'path' => 'admin.course.coaching-form.course-summary.assignments',
                        'section' => $section,
                    ])
                @else
                    <span class="fst-italic subtitle-color">No assignments</span>
                @endif

                @if($course->isActive())
                    <a href="{{route('get.admin.course.coaching_form.course_assignment', $section->course->id)}}?sectionToExpand={{$section->id}}"
                       title="Edit section assignments"
                       class="ms-2 small">
                        <i class="fa fa-edit"></i>
                    </a>
                @endif
            </div>
        </div>

    </div>
@endforeach

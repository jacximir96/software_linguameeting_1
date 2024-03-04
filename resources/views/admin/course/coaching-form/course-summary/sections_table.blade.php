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

<table class="table table-sm table-responsive table-bordered">
    <thead>
        <tr class="text-corporate-color">
            <th class="col-4">Name</th>
            <th class="col-3">Instructor</th>
            <th class="col-2">Class ID</th>
            <th class="col-2">Assignments</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sections as $section)
            <tr class="small">
                <td>
                    <span class="d-block fw-bold">{{$section->name}}</span>

                    <a href="{{route('get.common.course.section.file.instructions.download', $section->id)}}"
                       title="Download instructions"
                       class="small-font-size-08 d-block mt-2">
                        <i class="fa fa-download"></i> Student Instructions
                    </a>
                </td>
                <td>
                    {{$section->instructor->writeFullName()}}
                </td>
                <td class="text-center">
                    {{$section->code}}
                </td>
                <td>
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

                        @php $randomModalTable = \Str::random(16) @endphp
                        @if($course->isActive())
                        <a href="#"
                           class="text-decoration-underline small"
                           data-bs-toggle="modal"
                           data-bs-target="#modal-assignments-{{$randomModalTable}}">
                            Review
                        </a>
                        @endif

                        @include('common.modal_info', [
                            'modalId' => 'modal-assignments-'.$randomModalTable,
                            'modalTitle' => 'Assignments in Section '.$section->name,
                            'size' => 'modal-lg',
                            'path' => 'admin.course.coaching-form.course-summary.assignments',
                            'section' => $section,
                        ])
                    @else
                        <span class="fst-italic subtitle-color small-font-size-08">No assignments</span>
                    @endif

                    @if($course->isActive())
                        <a href="{{route('get.admin.course.coaching_form.course_assignment', $section->course->id)}}?sectionToExpand={{$section->id}}"
                           title="Edit section assignments"
                           class="ms-2 small-font-size-08">
                            <i class="fa fa-edit"></i>
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
    </tbody>
</table>

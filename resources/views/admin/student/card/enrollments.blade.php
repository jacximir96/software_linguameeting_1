<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light ">
        <span class="text-corporate-dark-color fw-bold">
            <i class="fas fa-file-alt me-1"></i>
            Student's Enrollments
        </span>
    </div>
    <div class="card-body  d-none d-md-block">
        <div class="table-responsive">

            <table id="" class="table table-hover">
                <thead>
                <tr class="small">
                    <th class="w-50">Course</th>
                    <th>Status</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($enrollments as $enrollment)

                    <tr>
                        <td class="w-50">
                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Course</span>
                                <a href="{{route('get.admin.course.show', $enrollment->course()->id)}}" class="d-inline-block" title="Show detail course">
                                    {{$enrollment->course()->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Section</span>
                                <a href="{{route('get.admin.course.show', $enrollment->course()->id)}}" class="d-inline-block ms-1" title="Show detail course">
                                    {{$enrollment->section->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Instructor</span>
                                <a href="{{route('get.admin.instructor.show', $enrollment->section->instructor_id)}}" class="d-inline-block ms-1" title="Show detail course">
                                    {{$enrollment->section->instructor->writeFullName()}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">University</span>
                                <a href="{{route('get.admin.university.show', $enrollment->university()->id)}}" class="" title="Show university">
                                    {{$enrollment->university()->name}}
                                </a>
                            </p>
                        </td>

                        <td>
                            @if ($enrollment->isActive())
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">{{$enrollment->status->description()}}</span>
                            @endif

                            <span class="d-block small text-muted">
                                {!! toDatetimeInTwoRow($enrollment->status_at, $timezone->name) !!}
                            </span>
                        </td>

                        <td>
                            {{$enrollment->section->course->start_date->format('m-d-y')}}
                        </td>
                        <td>
                            {{$enrollment->section->course->end_date->format('m-d-y')}}
                        </td>
                        <td>
                            <a href="{{route('get.admin.student.enrollment.show', $enrollment->id)}}"
                               class="open-modal text-primary"
                               data-modal-reload="no"
                               data-modal-size="modal-xl"
                               data-reload-type="parent"
                               data-modal-title='Show Enrollment'
                               title="Show Enrollment: {{$enrollment->user->writeFullName()}}">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No enrollments assigned</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-responsive d-block d-md-none">
            <table id="" class="table table-hover table-responsive">
                <thead>
                <tr class="small">
                    <th>Sections</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($enrollments as $enrollment)
                    <tr>
                        <td>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Course</span>
                                <a href="{{route('get.admin.course.show', $enrollment->course()->id)}}" class="d-inline-block" title="Show detail course">
                                    {{$enrollment->course()->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Section</span>
                                <a href="#" class="d-inline-block ms-1" title="Show detail course">
                                    {{$enrollment->section->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Instructor</span>
                                <a href="{{route('get.admin.instructor.show', $enrollment->section->instructor_id)}}" class="d-inline-block ms-1" title="Show detail course">
                                    {{$enrollment->section->instructor->writeFullName()}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">University</span>
                                <a href="{{route('get.admin.university.show', $enrollment->university()->id)}}" class="" title="Show university">
                                    {{$enrollment->university()->name}}
                                </a>
                            </p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No courses assigned</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

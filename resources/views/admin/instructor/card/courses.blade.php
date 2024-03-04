<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color text-white">
        <span class="">
            <i class="fas fa-headphones me-1"></i>
            Active Courses
        </span>
    </div>
    <div class="card-body">

        <div class="table-responsive d-none d-md-block">
            <table id="" class="table table-hover ">
            <thead>
            <tr class="small">
                <th>Name</th>
                <th>Start</th>
                <th>End</th>
                <th>Lingro?</th>
                <th>Access?</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @forelse ($courses as $course)

                <tr class="">
                    <td class="w-40">

                        @if ($showUniversityName)

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Course</span>
                                <a href="{{route('get.admin.course.show', $course->hashId())}}" class="d-inline-block {{$checkerDenyAccess->hasDenyAccessToCourse($course) ? 'text-danger' : ''}}"
                                   title="Show detail course. {{$checkerDenyAccess->hasDenyAccessToCourse($course) ? 'Instructor has access blocked.' : 'Instructor has access allowed.'}}">
                                    {{$course->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">University</span>
                                <a href="{{route('get.admin.university.show', $course->university->hashId())}}" class="" title="Show university">
                                    {{$course->university->name}}
                                </a>
                            </p>
                        @else

                            <a href="#" class="{{$checkerDenyAccess->hasDenyAccessToCourse($course) ? 'text-danger' : ''}}"
                               title="Show detail course. {{$checkerDenyAccess->hasDenyAccessToCourse($course) ? 'Instructor has access blocked.' : 'Instructor has access allowed.'}}">

                                {{$course->name}}
                            </a>

                        @endif

                    </td>
                    <td>
                        {{$course->start_date->format('y-m-d')}}
                    </td>
                    <td>
                        {{$course->end_date->format('y-m-d')}}
                    </td>
                    <td>
                        {{$course->isLingro() ? 'Yes' : 'No'}}
                    </td>

                    <td>
                        @if ($checkerDenyAccess->hasAllowedAccessToCourse($course))
                            <span class="text-success">Allowed</span>
                        @else
                            <span class="text-danger">Blocked</span>
                        @endif
                    </td>

                    <td>
                        @if ($checkerDenyAccess->hasAllowedAccessToCourse($course))
                            <a href="{{route('get.admin.course.user.change_status', [$course->hashId(), $instructor->hashId()])}}"
                               onclick="return confirm('Are you sure to block access to this course?');"
                               class=""
                               title="Block access to course">
                                <i class="fa fa-lock text-danger"></i>
                            </a>
                        @else
                            <a href="{{route('get.admin.course.user.change_status', [$course->hashId(), $instructor->hashId()])}}"
                               onclick="return confirm('Are you sure to allow access to this course?');"
                               class=""
                               title="Unlock access to course">
                                <i class="fa fa-lock-open text-success"></i>
                            </a>
                        @endif

                        @if ($checkerRole->isCourseCoordinator($data->commonResponse()->instructor()->rol()))
                            <a href="{{route('get.admin.course.course_coordinator.change', $course->hashId())}}"
                               class="open-modal ms-1"
                               data-modal-reload="yes"
                               data-reload-type="parent"
                               title="Change Course Coordinator">
                                <i class="fa fa-exchange-alt"></i>
                            </a>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <span class=" text-white bg-warning px-2 py-1 rounded ">No courses to show</span>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        <table id="" class="table table-hover d-md-none">
            <thead>
            <tr class="small">
                <th>Course</th>
            </tr>
            </thead>

            <tbody>
            @forelse ($courses as $course)

                <tr>
                    <td>
                        <p class="my-0">
                            <span class="d-block me-2 small  text-decoration-underline fw-bold">Course</span>

                            <a href="#"
                               class="{{$checkerDenyAccess->hasDenyAccessToCourse($course)  ? 'text-danger' : ''}} d-block"
                               title="Show detail course">
                                @if ($showUniversityName)
                                    {{$course->university->name}}
                                @endif
                                {{$course->name}}
                            </a>
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">University</span>
                            <span class="small fst-italic">
                                <a href="{{route('get.admin.university.show', $course->university->hashId())}}" class="d-block" title="Show university">
                                    {{$course->university->name}}
                                </a>
                            </span>
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">Dates</span>
                            <span class="small fst-italic">
                                {{$course->start_date->format('m/d/Y')}} <span class="fst-italic">to</span> {{$course->end_date->format('m/d/Y')}}
                            </span>
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">Lingro?</span>
                            <span class="small fst-italic">
                                {{$course->isLingro() ? 'Yes' : 'No'}}
                            </span>
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">Access?</span>
                            <span class="small fst-italic d-inline-block me-3">
                                 @if ($checkerDenyAccess->hasAllowedAccessToCourse($course) )
                                    <span class="text-success">Allowed</span>
                                @else
                                    <span class="text-danger">Blocked</span>
                                @endif
                            </span>

                            @if ($checkerDenyAccess->hasAllowedAccessToCourse($course) )

                                <a href="{{route('get.admin.course.user.change_status', [$course->hashId(), $instructor->hashId()])}}"
                                   onclick="return confirm('Are you sure to block access to this course?');"
                                   class=""
                                   title="Block access to course">
                                    <i class="fa fa-lock text-danger"></i>
                                </a>

                            @else
                                <a href="{{route('get.admin.course.user.change_status', [$course->hashId(), $instructor->hashId()])}}"
                                   onclick="return confirm('Are you sure to allow access to this course?');"
                                   class=""
                                   title="Unlock access to course">
                                    <i class="fa fa-lock-open text-success"></i>
                                </a>
                            @endif

                        </p>

                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        <span class=" text-white bg-warning px-2 py-1 rounded ">No courses to show</span>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>



        @if ($checkerRole->isCourseCoordinator($data->commonResponse()->instructor()->rol()))

            <div class="row mt-2">
                <div class="col-12 text-end">

                    <a href="{{route('get.admin.instructor.course.assign_multiple', $data->commonResponse()->instructor()->hashId())}}"
                       class="open-modal text-success"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-title='Assign courses'>
                        <i class="fa fa-plus"></i> Assign courses
                    </a>
                </div>
            </div>

        @endif
    </div>
</div>

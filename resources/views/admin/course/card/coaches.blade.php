<div class="card mb-4 bg">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fa fa-fw fa-chalkboard-teacher me-2"></i> Coaches
        </span>
    </div>
    <div class="card-body  d-none d-md-block">

        <div class="col-12 mb-3 ps-2 d-none d-lg-block">

            <table class="table table-responsive">
                <thead>
                <tr class="text-corporate-color">
                    <th class="">Name</th>
                    <th class="">Country</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($course->courseCoachSorted() as $courseCoach)
                        <tr class="small">
                            <td class="text-left">
                                <a href="{{route('get.admin.coach.show', $courseCoach->coach->id)}}" class="mr-2" title="Show coach">
                                    {{$courseCoach->coach->writeFullName()}}
                                </a>
                            </td>
                            <td class="">
                                <img src="{{asset('assets/img/flags/'.$courseCoach->coach->country->flagFile())}}"
                                     title="Flag of {{$courseCoach->coach->country->name}}"
                                     class="img-thumbnail flag-icon-25 me-20" />

                                {{$courseCoach->coach->country->name}}

                            </td>
                            <td class="">
                                <a href="{{route('get.admin.course.coach.delete', [$courseCoach->course_id, $courseCoach->coach_id])}}"
                                   class="text-danger"
                                   onclick="return confirm('Are you sure to remove this coach from course?');">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                No coaches assigned
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-12">

            <a href="{{route('get.admin.course.coach.assign', $course)}}"
               class="open-modal d-block mt-1 text-success float-end"
               data-modal-size="modal-md"
               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title="Assign Coach">
                <i class="fa fa-plus"></i> Assign Coach
            </a>
        </div>



    </div>

</div>



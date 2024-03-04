<div class="col-12 py-2 mb-2 rounded" style="background-color: rgba(53, 180, 180,0.2)">
    <div class="row">
        <div class="col-12 text-start">
            <span class="text-corporate-dark-color fw-bold ms-2 me-3"><i class="fa fa-fw fa-calendar-week me-2"></i> Flex Option</span>
            @if($course->isActive())
            <a href="{{route('get.admin.course.coaching_form.coaching_weeks', $course->id)}}" class="small" title="Edit sessions">
                <i class="fa fa-edit"></i>
            </a>
            @endif
        </div>
    </div>
</div>


<div class="col-12 mb-3 ps-2">
    <p>
        Students are able to book sessions any time between the course start and end dates.
    </p>
</div>


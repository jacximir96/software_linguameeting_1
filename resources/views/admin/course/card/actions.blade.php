<div class="row gx-3 mb-4">

    <div class="col-sm-3">
        <a href="{{route('get.admin.course.edit.basic', $course->id)}}"
           title="Edit"
           target="_blank"
           class="open-modal text-primary"
           data-modal-reload="yes"
           data-reload-type="parent"
           data-modal-title='Edit course'>
            <i class="fa fa-edit"></i> Edit
        </a>
    </div>

    <div class="col-sm-3 mt-3 mt-sm-0">
        <a href="{{$course->editUrl()->get()}}"
           title="Edit in Coaching Form"
           target="_blank"
           class="text-primary me-3 "><i class="fa fa-edit"></i> Coaching Form</a>
    </div>

    @if ($course->serviceType->isConversations())
        <div class="col-sm-3 mt-3 mt-sm-0">
            <a href="{{route('get.admin.course.make_up.edit', $course->id)}}"
               title="Edit make-ups"
               target="_blank"
               class="open-modal text-primary me-5"
               data-modal-size="modal-md"
               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title='Edit make-ups'>
                <i class="fa fa-edit"></i> Make-Up
            </a>
        </div>

        <div class="col-sm-3 mt-3 mt-sm-0">
            <a href="{{route('get.admin.course.make_up.assign', $course->id)}}"
               title="Add Make-ups"
               target="_blank"
               class="open-modal text-primary me-5"
               data-modal-size="modal-md"
               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title='Add Make-ups'>
                <i class="fa fa-plus"></i> Add Make-ups
            </a>
        </div>
    @endif
</div>


<div class="row gx-3 mb-4 mt-4">

    <div class="col-sm-3">
        <a href="{{$course->routes()->downloadSummary()->get()}}"
           title="Downlad course summary"
           class="me-3">
            <i class="fa fa-download"></i> Download Summary
        </a>
    </div>

    <div class="col-sm-3 mt-3 mt-sm-0">
        <a href="{{route('get.admin.course.documentation.send.show_log', $course->id)}}"
           title="Send Documentation"
           class="me-3 open-modal"
           data-modal-size="modal-lg"
           data-modal-reload="no"
           data-modal-title='Section documentation submission log'>
            <i class="fa fa-envelope"></i> Send Documentation
        </a>
    </div>

    <div class="col-sm-3 mt-3 mt-sm-0">
        <a href="{{route('get.admin.course.log.activity.show', $course->id)}}"
           class="open-modal"
           data-modal-size="modal-xl"
           data-modal-reload="no"
           data-modal-title='Activity log'
           target="_blank">
            <i class="fa fa-history"></i> Show activity log
        </a>
    </div>

    <div class="col-sm-3 mt-3 mt-sm-0">
        <a href="{{route('get.admin.course.student.index', $course->id)}}"
           class="open-modal"
           data-modal-size="modal-xl"
           data-modal-reload="no"
           data-modal-title='Students'
           target="_blank">
            <i class="fa fa-users"></i> {{$course->enrollment()->count()}} Students
        </a>
    </div>
</div>

@if ($course->serviceType->isConversations())
    <div class="row gx-3 mb-4 mt-4">
        <div class="col-sm-3">
            <a href="{{route('get.admin.course.schedule.index', $course->id)}}"
               class="me-3 open-modal text-primary"
               data-modal-reload="no"
               data-modal-size="modal-xl"
               data-reload-type="parent"
               data-modal-title='Show schedule: {{$course->name}}'
               title="Show Schedule">
                <i class="fa fa-calendar-week"></i> Schedule
            </a>
        </div>
    </div>
@endif

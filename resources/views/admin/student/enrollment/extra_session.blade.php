<div class="row mt-2">

    <div class="col-md-4">
        <p class="my-0">
            <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Type</span>
            <span>{{$otherSession->writeType()}}</span>

            @if ($otherSession->isMakeup())

                <a href="{{route('get.admin.student.makeup.edit', $otherSession->get()->id)}}"
                   class="open-modal ms-1 small text-primary"
                   data-modal-reload="yes"
                   data-modal-size="modal-md"
                   data-reload-type="parent"
                   data-modal-title='Edit Makeup'
                   title="Edit Makeup">
                    <i class="fa fa-edit"></i>
                </a>

                @if ( ! $otherSession->get()->hasBeenUsed())
                    <a href="{{route('get.admin.student.makeup.delete', $otherSession->get()->id)}}"
                       class="ms-1 small text-danger"
                       onclick="return confirm('Are you sure to remove this makeup?');"
                       title="Delete Makeup">
                        <i class="fa fa-times"></i>
                    </a>
                @endif
            @else
                @if ( ! $otherSession->get()->hasBeenUsed())
                    <a href="{{route('get.admin.student.extra_session.delete', $otherSession->get()->id)}}"
                       class="ms-1 small text-danger"
                       onclick="return confirm('Are you sure to remove this extra session?');"
                       title="Delete Extra Session">
                        <i class="fa fa-times"></i>
                    </a>
                @endif
            @endif
        </p>
    </div>
    <div class="col-md-4">
        <p class="my-0">
            <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Origin</span>
            {{$otherSession->writeOrigin()}}
        </p>
    </div>

    <div class="col-md-4">
        <p class="my-0 ">
            <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Allocator</span>
            <a href="#" title="Show Instructor">{{$otherSession->allocator()->writeFullName()}}</a>
        </p>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-4">
        <p class="my-0 ">
            <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Assigned at</span>
            {{$otherSession->moment()->format('d/m/Y H:i:s')}}
        </p>
    </div>
    <div class="col-md-4">
        <p class="my-0 ">
            <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Money</span>
            @if ($otherSession->isMakeup())
                @if ($otherSession->get()->isFree())
                    <i class="fa fa-circle text-success"></i> Free
                @else
                    <i class="fa fa-dollar-sign text-primary"></i> Paid
                @endif
            @else
                <i class="fa fa-circle text-success"></i> Free
            @endif
        </p>
    </div>
    <div class="col-md-4">
        <p class="my-0 ">
            @if ($otherSession->isMakeup())
                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Session</span>

                @if ($otherSession->get()->enrollmentSession)
                    <span class="fw-bold text-corporate-dark-color" title="Makeup correspondiente a la sesión {{$otherSession->get()->enrollmentSession->sessionOrder()->get()}}">
                        <i class="fa fa-check text-success me-2"></i> <span>{{$otherSession->get()->enrollmentSession->sessionOrder()->get()}}</span>
                    </span>
                @else
                    -
                @endif
            @else
                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Session</span>

                @if ($otherSession->get()->enrollmentSession)
                    <span class="fw-bold text-corporate-dark-color" title="Extra Session correspondiente a la sesión {{$otherSession->get()->enrollmentSession->sessionOrder()->get()}}">
                        {{$otherSession->get()->sessionOrder()->get()}}
                    </span>
                @else
                    -
                @endif
            @endif
        </p>
    </div>
</div>

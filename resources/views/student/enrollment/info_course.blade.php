<div class="row">
    <div class="col-12">
        <div class="col-12">
            <h5 class="p-1 rounded bg-corporate-color-light text-corporate-dark-color fw-bold">Your Course</h5>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        @include('student.dashboard.info_enrollment', ['enrollment' => $viewData->enrollment()])
    </div>
</div>


@if ($viewData->extraSessionsAvailable()->count())
    <div class="row mt-5">
        <div class="col-12">
            <a href="{{route('get.student.session.book.extra_session.use', [$viewData->enrollment()->hashId(), $viewData->sessionOrder()->get()])}}"
               class="fw-bold text-corporate-dark-color"
               data-modal-reload="yes"
               data-modal-size="modal-md"
               data-reload-type="parent"
               data-modal-title="Use Extra Session"
               title="Use Extra Session">
                Extra Sessions ({{$viewData->extraSessionsAvailable()->count()}})
            </a>
        </div>
    </div>

@endif


@if ($viewData->enrollment()->isActive())
<div class="row mt-3">
    <div class="col-12">
        <a href="{{route('get.student.enrollment.change.section', $viewData->enrollment()->hashId())}}"
           class="open-modal fw-bold text-corporate-dark-color"
           data-modal-reload="yes"
           data-modal-size="modal-md"
           data-reload-type="parent"
           data-modal-title="Change Section/Course"
           title="Change Section/Course">
            Change Section/Course
        </a>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <a href="#"
           class="d-inline-block fw-bold text-corporate-danger"
           data-bs-toggle="modal"
           data-bs-target="#modal-refund-{{$viewData->enrollment()->hashId()}}">
            Refund
        </a>

        @include('common.modal_info', [
            'modalId' => 'modal-refund-'.$viewData->enrollment()->hashId(),
            'modalTitle' => 'Refund',
            'size' => 'modal-md',
            'path' => 'admin.student.enrollment.refund.confirmation',
            'enrollment' => $viewData->enrollment(),
            'noFooter' => true,
        ])
    </div>
</div>
@endif

<i class="fa fa-circle fa-xs {{$enrollmentSession->status->colorCssClass()}}" title="Session Attendance: {{$enrollmentSession->status->title()}}"></i>
<span class="d-inline-block fw-bold me-2">{{$enrollmentSession->enrollment->user->writeFullName()}}</span>

@include('admin.student.accommodation.link', ['enrollment' => $enrollmentSession->enrollment])

@if ($enrollmentSession->isMakeupWeek())
    <span class="text-corporate-dark-color small d-inline-block fw-bold ms-2 p-0 bg-corporate-color-light">Additional Make-Up Period</span>
@endif

@php
    $urlFeedback = route('get.common.enrollments.session.feedback.create', $enrollmentSession->id);
    if ($enrollmentSession->hasFeedback()){
        $urlFeedback = route('get.common.enrollments.session.feedback.update', $enrollmentSession->feedback->id);
    }
@endphp

<a href="{{$urlFeedback}}"
   class="open-modal float-end {{$enrollmentSession->hasFeedback() ? 'text-success' : 'text-danger'}} small"
   data-modal-reload="yes"
   data-modal-size="modal-xl"
   data-modal-height="h-95"
   data-reload-type="parent"
   data-modal-title="{{$enrollmentSession->hasFeedback() ? 'Update' : 'Create'}} Session Feedback: {{$enrollmentSession->enrollment->user->writeFullName()}}"
   title="{{$enrollmentSession->hasFeedback() ? 'Update' : 'Create'}} Session Feeedback">
    <i class="fa fa-comment-dots"></i> {{$enrollmentSession->hasFeedback() ? 'Feedback' : 'No Feedback'}}
</a>

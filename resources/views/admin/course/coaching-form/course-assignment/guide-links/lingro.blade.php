<span clasS="text-corporate-dark-color">Need some activities?</span>
<span class="subtitle-color">Check out our</span>

@if ($course->conversationGuide->hasLingroGuide())
    <a href=""
       class="text-corporate-color-lighter text-decoration-underline fw-bold"
       data-bs-toggle="modal" data-bs-target="#conversation-guides"
       title="Show Conversation Guide">
        {{$course->conversationGuide->name}} Conversation Guides
    </a>


@else
    <a href=""
       class="text-corporate-color-lighter text-decoration-underline fw-bold"
       data-bs-toggle="modal" data-bs-target="#conversation-guides"
       title="Show Conversation Guide">
        Linguameeting Conversation Guides
    </a>
@endif

<span class="subtitle-color">and select one for each session.</span>

@include('common.modal_info', [
            'guide' => $guide,
           'modalId' => 'conversation-guides',
           'modalTitle' => 'LinguaMeeting Conversation Guides',
           'size' => 'modal-lg',
           'path' => 'admin.course.coaching-form.course-assignment.guides'
       ])


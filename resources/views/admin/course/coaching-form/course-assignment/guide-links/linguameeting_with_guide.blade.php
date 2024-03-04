<span clasS="text-corporate-dark-color">Need some activities?</span>
<span class="subtitle-color">Check out our</span>
<a href=""
   class="text-corporate-color-lighter text-decoration-underline fw-bold"
   data-bs-toggle="modal" data-bs-target="#conversation-guides"
   title="Show Conversation Guide">
    LinguaMeeting Conversation Guides
</a>
<span class="subtitle-color">and select one for each session.</span>

@include('common.modal_info', [
             'guide' => $guide,
           'modalId' => 'conversation-guides',
           'modalTitle' => 'LinguaMeeting Conversation Guides',
           'size' => 'modal-lg',
           'path' => 'admin.course.coaching-form.course-assignment.guides'
       ])

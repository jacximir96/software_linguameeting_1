<span clasS="text-corporate-dark-color">Need some activities?</span>
<span class="subtitle-color">Check out our</span>
<a href="#"
   data-bs-toggle="modal" data-bs-target="#examples-new-assignments-guides"
   target="_blank"
   class="text-corporate-color-lighter text-decoration-underline fw-bold">LinguaMeeting Assignment Example</a>
<span class="subtitle-color">and create your assignment for each session.</span>

@include('common.modal_info', [
           'modalId' => 'examples-new-assignments-guides',
           'modalTitle' => 'LinguaMeeting Assignment Example',
           'size' => 'modal-lg',
           'path' => 'admin.course.coaching-form.course-assignment.templates',
           'templates' => $templates
       ])

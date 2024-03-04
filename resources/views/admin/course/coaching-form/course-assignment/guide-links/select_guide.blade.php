<p>
    @if ($instructionsFinder->isForLinguameetingWithoutGuide($course))
        @include('admin.course.coaching-form.course-assignment.guide-links.linguameeting_not_guide')
    @elseif ($instructionsFinder->isForLinguameetingWithGuide($course))
        @include('admin.course.coaching-form.course-assignment.guide-links.linguameeting_with_guide')
    @elseif($course->conversationGuide->hasLingroGuide())
        @include('admin.course.coaching-form.course-assignment.guide-links.lingro')
    @elseif($course->conversationGuide->hasLingroWithoutGuide())
        @include('admin.course.coaching-form.course-assignment.guide-links.lingro')
    @endif
</p>

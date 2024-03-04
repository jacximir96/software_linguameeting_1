@if ($instructorOf)
    <a href="{{route('get.admin.instructor.show', \Vinkla\Hashids\Facades\Hashids::encode($teachingAssistant->assistant_id))}}"
       class="text-primary me-3" title="Show instructor">
        {{$teachingAssistant->assistant->writeFullName()}}
    </a>
@else
    <a href="{{route('get.admin.instructor.show', \Vinkla\Hashids\Facades\Hashids::encode($teachingAssistant->instructor_id))}}"
       class="text-primary me-3" title="Show instructor">
        {{$teachingAssistant->instructor->writeFullName()}}
    </a>
@endif

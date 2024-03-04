<div class="">
    @php $university = $printer->university() @endphp
    <span class="fw-bold me-2">University</span>
    <a href="{{route('get.admin.university.show', $university->id)}}" title="Show University" target="_blank">
        {{$printer->university()->name}}
    </a>
</div>


<div class="">
    @php $course = $printer->course() @endphp
    <span class="fw-bold me-2">Course</span>
    <a href="{{route('get.admin.course.show', $course->id)}}" title="Show Course" target="_blank">
        {{$printer->course()->name}}
    </a>
</div>

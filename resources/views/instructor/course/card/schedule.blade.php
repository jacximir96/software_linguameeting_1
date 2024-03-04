<div class="container mt-5">
@if ($course->isFlex())
    <div class="row">
        <div class="col-12">
            @include('admin.course.schedule.content_flex')
        </div>
    </div>

@else
    <div class="row">
        <div class="col-12">
            @include('admin.course.schedule.content_weeks')
        </div>
    </div>

@endif

</div>

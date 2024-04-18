<div class="container mt-3">

<div class="row ">
    <div class="col-12">
        @include('admin.course.coaching-form.course-assignment.instructions')
    </div>
</div>

<div class="accordion mt-2" id="accordionExample">

    @foreach ($course->section as $section)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button {{$sectionCourse == $section->hashId() ? '' : 'collapsed'}}"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#section-{{$section->hashId()}}"
                        aria-expanded="true" aria-controls="section-{{$section->hashId()}}">
                    <span class="fw-bold text-corporate-dark-color">{{$section->name}}</span>
                    <span class="ms-5 fw-bold">{{$section->instructor->writeFullName()}}</span>
                    <span class="ms-5 fw-bold">{{$section->code}}</span>
                </button>
            </h2>
            <div id="section-{{$section->hashId()}}" class="accordion-collapse collapse {{$sectionCourse == $section->hashId() ? 'show' : ''}}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @if ($isSmallGroup)
                        @include('instructor.course.card.assignment_weeks')
                    @else
                        @include('instructor.course.card.assignment_one_on_one')
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>

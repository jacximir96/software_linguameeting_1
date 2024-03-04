<div class="row mt-4">
    <div class="col-12">
        <span class="title-field-form "><i class="fa fa-comments fa-fw"></i> Conversation Guides</span>
    </div>
    <div class="col-12 mt-2">
        @include('admin.course.coaching-form.course-assignment.guide-links.select_guide')
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <h6 class="title-field-form">Sections</h6>
    </div>
</div>

<div class="row mt-0">
    <div class="col-12">
        <div class="accordion" id="accordionSection">

                @foreach ($viewData->sections() as $section)

                    <div class="accordion-item shadow--" id="accordion-item-{{$section->id}}" >

                        @if ($course->isFlex())

                            @include('admin.course.coaching-form.course-assignment.one_on_one_flex', [
                                'statusSection' => $section->statusAssignment(),
                            ])

                        @else

                            @include('admin.course.coaching-form.course-assignment.one_on_one_weeks', [
                                'statusSection' => $section->statusAssignment(),
                            ])

                        @endif
                    </div>
                @endforeach

        </div>
    </div>
</div>

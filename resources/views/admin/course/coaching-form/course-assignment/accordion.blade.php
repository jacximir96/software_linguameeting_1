@foreach ($viewData->sectionsAssignment() as $sectionAssignment)

    <div class="accordion-item shadow--" id="accordion-item-{{$sectionAssignment->sectionId()}}" >

        @if ($course->isFlex())

            @include('admin.course.coaching-form.course-assignment.section_flex', [
            'sectionAssignment' => $sectionAssignment,
            'sessionsFlex' => $viewData->flexSessions(),
            'statusSection' => $sectionAssignment->section()->statusAssignment(),
            ])

        @else

            @include('admin.course.coaching-form.course-assignment.section_week_v2', [
            'sectionAssignment' => $sectionAssignment,
            'coachingWeeks' => $viewData->coachingWeeks(),
            'statusSection' => $sectionAssignment->section()->statusAssignment(),
            ])

        @endif


    </div>
@endforeach

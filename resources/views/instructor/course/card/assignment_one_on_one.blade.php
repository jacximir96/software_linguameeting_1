{{ Form::model($viewDataSection->form()->model(),  [
                               'class' => '',
                               'url'=> $viewDataSection->form()->action(),
                               'autocomplete' => 'off',
                               'id' =>'assignments-form-course'
                               ]) }}
<div class="row mt-4">
    <div class="col-9">
        <span class="title-field-form "><i class="fa fa-comments fa-fw"></i> Conversation Guides</span>
    </div>
    <div class="col-3" style="text-align: center">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view{{$section->id}}">
            <i class="fa fa-users"></i>&nbsp;&nbsp;View Attendance
        </button>
    </div>
    <div class="col-12 mt-2">
        @include('admin.course.coaching-form.course-assignment.guide-links.select_guide')
    </div>
</div>

<div class="row mt-0">
    <div class="col-12">
        @if ($course->isFlex())
            @include('instructor.course.card.assignment_one_on_one_flex', [
                'statusSection' => $section->statusAssignment(),
                'viewData' => $viewDataSection,
            ])
        @else

            @include('instructor.course.card.assignment_one_on_one_weeks', [
                'statusSection' => $section->statusAssignment(),
                'viewData' => $viewDataSection,
            ])
        @endif
    </div>
</div>


{{Form::close()}}

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
        <a href="" data-toggle="modal" data-target="#view{{$section->id}}" style="color:black"><i class="fa fa-users"></i>&nbsp;&nbsp;View Attendance</a>
    </div>
    
    <div class="col-12 mt-2">
        @include('admin.course.coaching-form.course-assignment.guide-links.select_guide')
    </div>
    
</div>

@if ($course->isFlex())

    @include('admin.course.coaching-form.course-assignment.small_group_flex', [
        'course' => $viewDataSection->course(),
        'section' => $viewDataSection->course()->section->first(),
        'form' => $viewDataSection->form(),
    ])
@else

    @if ($course->hasCoachingWeek())

        @include('admin.course.coaching-form.course-assignment.small_group_weeks', [
            'course' => $viewDataSection->course(),
            'section' => $viewDataSection->course()->section->first(),
            'form' => $viewDataSection->form(),
        ])
    @else
        <div class="row mt-4 mx-auto">
            <div class="col-12 alert alert-warning">
                <span class="h">Es necesario tener coaching weeks configuradas para poder configurar los assignments.</span>
            </div>
        </div>
    @endif
@endif


{{Form::close()}}

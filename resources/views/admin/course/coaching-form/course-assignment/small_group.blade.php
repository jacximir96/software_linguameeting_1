{{ Form::model($viewData->form()->model(),  [
                               'class' => '',
                               'url'=> $viewData->form()->action(),
                               'autocomplete' => 'off',
                               'id' =>'assignments-form-course'
                               ]) }}

<div class="row mt-4">
    <div class="col-12">
        <span class="title-field-form "><i class="fa fa-comments fa-fw"></i> Conversation Guides</span>
    </div>
    <div class="col-12 mt-2">
        @include('admin.course.coaching-form.course-assignment.guide-links.select_guide')
    </div>
</div>

<div class="row mt-0">

    <div class="col-12">

        <div class="div-sessions" id="div-sessions">

            @if ($course->isFlex())

                @include('admin.course.coaching-form.course-assignment.small_group_flex', [
                    'course' => $viewData->course(),
                    'section' => $viewData->course()->section->first(),
                    'form' => $viewData->form(),
                ])
            @else

                @if ($course->hasCoachingWeek())

                    @include('admin.course.coaching-form.course-assignment.small_group_weeks', [
                        'course' => $viewData->course(),
                        'section' => $viewData->course()->section->first(),
                        'form' => $viewData->form(),
                    ])
                @else
                    <div class="row mt-4 mx-auto">
                        <div class="col-12 alert alert-warning">
                            <span class="h">Es necesario tener coaching weeks configuradas para poder configurar los assignments.</span>
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>

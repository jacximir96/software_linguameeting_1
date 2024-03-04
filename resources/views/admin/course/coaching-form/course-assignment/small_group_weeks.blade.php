@foreach ($course->coachingWeeksOrderedWithoutMakeUps() as $coachingWeek)
    <div class="row border-bottom shadow-sm d-flex align-items-center py-2 bg-corporate-color-lighter-2"  name="anchor-accordion-{{$section->id}}">
        <div class="col-12 col-sm-6 col-md-6 col-xl-2 text-start ">
            <span class="fw-bold text-corporate-color h5 d-none d-md-block    ">Session {{$loop->iteration}}</span>
            <span class="fw-bold text-corporate-color h6 d-block d-md-none mb-0 pb-0   ">Session {{$loop->iteration}}</span>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-xl-3 mt-2 mt-sm-0 text-start text-sm-end text-xl-start p-xl-0">
            <span class="subtitle-color fw-bold ">{{$coachingWeek->start_date->format('m/d/Y')}} - {{$coachingWeek->end_date->format('m/d/Y')}}</span>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-7 col-xl-4 mt-2 mb-2">
            @if ($form->hasChaptersOptions())
            {{Form::select('chapter_id['.$coachingWeek->id.']', $form->chaptersOptions(), null,
                            [   'class'=>'form-input-chapter-id week-small-group-chapter-id form-control form-select ',
                                'placeholder' => 'Select Conversation Guide',
                                'data-url-update' => route('post.common.course.assignment.api.guide.update.week.small', $coachingWeek->id)
                                ])}}
                @endif
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-3 mt-2 mt-sm-0 text-sm-end text-xl-center">
            <a href="{{route('get.common.course.assignment.week.edit',[$section->id, $coachingWeek->id])}}"
               class="open-modal btn border-1 small p-0"
               style="font-size: 0.875em;"
               data-modal-reload="yes"
               data-modal-size="modal-lg"
               data-reload-type="parent"
               data-reload-url="{{url()->current()}}?time={{time()}}"
               data-modal-title="Manage Assignments"
               title="Manage assignments">
                @if ($coachingWeek->hasAssignments())
                    <i class="fa fa-check text-success"></i> Assignment
                @else
                    <i class="fa fa-plus"></i> Create Assignment
                @endif
            </a>
        </div>
    </div>
@endforeach

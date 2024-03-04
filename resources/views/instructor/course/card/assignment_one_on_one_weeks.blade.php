@foreach ($viewData->coachingWeeks() as $coachingWeek)

    <div class="row border-bottom d-flex align-items-center py-2">
        <div class="col-12 col-sm-6 col-md-6 col-xl-2 text-start ">
            <span class="fw-bold text-corporate-color h5 d-none d-md-block  ">Session {{$loop->iteration}}</span>
            <span class="fw-bold text-corporate-color h6 d-block d-md-none mb-0 pb-0  ">Session {{$loop->iteration}}</span>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-xl-3 mt-2 mt-sm-0 text-start text-sm-end text-xl-start p-xl-0">
            <span class="subtitle-color fw-bold ">{{toDate($coachingWeek->start_date)}} - {{toDate($coachingWeek->end_date)}}</span>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-7 col-xl-4 mt-2 mb-2">
            @if ($viewData->chaptersOptions ()->count())
                {{Form::select('chapter_id['.$section->id.'-'.$coachingWeek->id.']', $viewData->chaptersOptions(), null,
                                [
                                    'class'=>'form-input-chapter-id week-one-on-one-chapter-id form-control form-select ',
                                    'placeholder' => 'Select Conversation Guide',
                                    'data-url-update' => route('post.common.course.assignment.api.guide.update.week.one_on_one', [$section->id, $coachingWeek->id])
                                ])}}
            @endif
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-3 mt-2 mt-sm-0 text-sm-end text-xl-center">
            <a href="{{route('get.common.course.assignment.week.edit',[$section->id, $coachingWeek->id])}}"
               class="open-modal btn border-1 rounded small p-0"
               style="font-size: 0.875em;"
               data-modal-reload="yes"
               data-modal-size="modal-lg"
               data-reload-type="parentWithUrl"
               data-reload-url="{{url()->current()}}?sectionToExpand={{$section->id}}&time={{time()}}#anchor-accordion-{{$section->id}}"
               data-modal-title="Manage Assignments"
               title="Manage assignments">
                @if ($section->hasAssignmentsInWeek($coachingWeek))
                    <i class="fa fa-check text-success"></i> Assignment
                @else
                    <i class="fa fa-plus"></i> Create Assignment
                @endif
            </a>
        </div>
    </div>
@endforeach

@if ($viewData->showApplyToAllSectionsButton())
    <div class="row my-4">
        <div class="col-12">
            <button type="submit"
                    class="btn btn-sm bg-corporate-dark-color text-white btn-apply-for-all"
                    data-section-id="{{$section->id}}"
                    name="action"
                    value="to_all_sections">Apply Assignments to All Sections
            </button>
        </div>
    </div>
@endif

<h2 class="accordion-header" id="heading{{$section->id}}"  name="anchor-accordion-{{$section->id}}">
    <button class="accordion-button {{ $viewData->sectionToExpand($section->id) ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse{{$section->id}}" aria-expanded="true"
            aria-controls="collapse{{$section->id}}">
        {{$section->name}} / {{$section->instructor->writeFullName() ?? 'Without instructor assigned'}}

        @if ($statusSection->isCompleted())
            <span class="fw-bold text-success ms-4 small">
                Completed!!
            </span>
        @else
            <span class="text-danger ms-4 small status-section" title="{{$statusSection->completed()}} sessions completed out of {{$statusSection->totalSessions()}}">
                {{$statusSection->completed()}} of {{$statusSection->totalSessions()}} assigned guides.
            </span>
        @endif
    </button>
</h2>
<div id="collapse{{$section->id}}" class="accordion-collapse collapse accordion-assignment  {{ $viewData->sectionToExpand($section->id) ? 'show' : ''}}"
     aria-labelledby="heading{{$section->id}}"
     data-bs-parent="#accordionSection">
    <div class="accordion-body p-2 py-md-2 px-md-3 body-{{$section->id}}" style="background-color: #35b4b417;">

        @foreach ($viewData->flexSessions()->get() as $flexSession)

            <div class="row border-bottom d-flex align-items-center py-2">
                <div class="col-12 col-sm-6 col-xl-3">
                    <span class="fw-bold text-corporate-color h5 d-none d-md-block">Session {{$loop->iteration}}</span>
                    <span class="fw-bold text-corporate-color h6 d-block d-md-none mb-0 pb-0">Session {{$loop->iteration}}</span>
                </div>
                <div class="col-12 col-sm-6 col-xl-1 mt-2">
                    <span class="subtitle-color fw-bold "></span>
                </div>
                <div class="col-12 col-sm-6 col-md-7 col-xl-5 mt-2 mb-2">
                    @if ($viewData->chaptersOptions ()->count())
                        {{Form::select('chapter_id['. $section->id.'-'.$flexSession->number().']', $viewData->chaptersOptions(), null,
                                        [   'class'=>'form-input-chapter-id flex-one-on-one-chapter-id form-control form-select select-section-'.$section->id,
                                            'placeholder' => 'Select Conversation Guide',
                                            'data-url-update' => route('post.common.course.assignment.api.guide.update.flex.one_on_one', [$section->id, $flexSession->number()])
                                            ])}}
                    @endif
                </div>
                <div class="col-12 col-sm-6 col-md-5 col-xl-3 mt-2 mt-sm-0 p-0 text-sm-center">
                    <a href="{{route('get.common.course.assignment.flex.edit',[$section->id, $flexSession->number()])}}"
                       class="open-modal btn border-1 rounded small"
                       style="font-size: 0.875em;"
                       data-modal-reload="yes"
                       data-modal-size="modal-lg"
                       data-reload-type="parentWithUrl"
                       data-reload-url="{{url()->current()}}?sectionToExpand={{$section->id}}&time={{time()}}#anchor-accordion-{{$section->id}}"
                       data-modal-title="Manage Assignments"
                       title="Manage assignments">
                        @if ($section->hasAssignmentsInFlex($flexSession->number()))
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
    </div>

    <div class="accordion-header text-end pe-3" id="heading{{$section->id}}">
        <a class="{{ $viewData->sectionToExpand($section->id) ? '' : 'collapsed'}} text-right subtitle-color h4 close-collapse-icon"
           href="#"
           style="background-color: #FFF;"
           data-bs-toggle="collapse"
           data-bs-target="#collapse{{$section->id}}" aria-expanded="true"
           aria-controls="collapse{{$section->id}}"><i class="fa fa-angle-up"></i></a>

        </button>
    </div>
</div>

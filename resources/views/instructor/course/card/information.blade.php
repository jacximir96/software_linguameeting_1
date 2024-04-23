<div class="container mt-5">
  
    <div class="row">
        <div class="col-md-5 ">
            <div class="row p-2 boxBlueSummary color4" style="background-color: rgba(53, 180, 180,0.2)">
                <div class="col-md-6 text-corporate-dark-color fw-bold">Course Name</div>
                <div class="col-md-6 text-corporate-dark-color">
                    {{$course->name}}

                    @if ($course->serviceType->isCombined())
                        (LinguaMeeting + Experiences)
                    @endif
                </div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Course Start Date:</strong></div>
                <div class="col-md-6"> {{toMonthDayYear($course->start_date)}}</div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Course End Date:</strong></div>
                <div class="col-md-6"> {{toMonthDayYear($course->end_date)}}</div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Holidays</strong></div>
                <div class="col-md-6">
                    @if ($course->holiday->count())
                        {{ $course->holiday->implode(function ($holiday){return toDate($holiday->date);},', ') }}
                    @else
                        <span class="fst-italic">No holidays</span>
                    @endif
                </div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Semester:</strong></div>
                <div class="col-md-6"> {{$course->semester->name}}</div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Year:</strong></div>
                <div class="col-md-6"> {{$course->year}}</div>
            </div>
        </div>
        <div class="offset-md-1 col-md-5 ">
            <div class="row p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Language:</strong></div>
                <div class="col-md-6"> {{ $course->language->name}}</div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Type Course: </strong></div>
                <div class="col-md-6">
                   {{$course->conversationPackage->name}} - {{$course->conversationPackage->isbn}}
                </div>
            </div>
            <div class="row mt-3 p-2 bg-gray-lighter">
                <div class="col-md-6"><strong>Make-ups available to students for purchase:</strong></div>
                <div class="col-md-6">
                    {{$course->printMakeupsNumber()}}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <a href="{{route('get.admin.course.section.coaching_form.file.download_summary', $course->hashId())}}"
                       title="Downlad course summary"
                       class="btn btn-primary btn-sm fw-bold px-4 " type="submit">
                        <i class="fa fa-download"></i> Download Summary
                    </a>
                </div>
                <div class="col-md-6 bg-corporate-color-light p-2"><label for="canvasCourseId"> <strong>Canvas Course ID:</strong> </label> <input type="text" class="form-control" id="canvasCourseId"
                                                                                                                                               value="">
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm bg-corporate-color text-white small" onclick="saveCanvasId(1499)"> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

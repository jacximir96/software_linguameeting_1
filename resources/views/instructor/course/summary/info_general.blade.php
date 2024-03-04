
        <div class="card p-3">


            <div class="row">
                <div class="col-12">
                    <span class="h4 me-3 text-corporate-dark-color">LinguaMeeting Course Summary</span>
                    @if($course->isActive())
                    <a href="{{route('get.admin.course.coaching_form.update.course_information', $course->id)}}"
                       class="small"
                       title="Edit course information">
                        <i class="fa fa-edit"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center text-corporate-color">
                    <span class="d-block h5">{{$course->name}}</span>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12 text-center text-corporate-color">
                    <span class="d-block h5">{{$course->semester->name}}, {{$course->year}}</span>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center subtitle-color">
                                        <span class="h5">
                                            {{toDate($course->start_date)}} - {{toDate($course->end_date)}}
                                        </span>

                    @if($course->isActive())
                    <a href="{{route('get.admin.course.coaching_form.create.update.academic_dates', $course->id)}}"
                       class=" h6 small"
                       title="Edit school information">
                        <i class="fa fa-edit"></i>
                    </a>
                    @endif


                </div>
            </div>


            <div class="row mt-3">
                <div class="col-sm-6 col-lg-4 text-center">
                    <div class="cicleSessions">{{$course->conversationPackage->sessionType->code}}</div>
                    <div class="circleText text-16 text_center">
                        {{$course->conversationPackage->sessionType->name}}
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 text-center mt-4 mt-sm-0">
                    <div class="cicleSessions">
                        {{$course->conversationPackage->number_session}}
                    </div>
                    <div class="circleText text-16 text_center">
                        Sessions
                    </div>
                </div>
                <div class="col-lg-4 text-center mt-4 mt-md-0">
                    <div class="cicleSessions">
                        {{$course->conversationPackage->duration_session}}
                    </div>
                    <div class="circleText text-16 text_center">
                        Minutes
                    </div>
                </div>
            </div>

            @if ($course->serviceType->isCombined())
                <div class="row mt-4">

                    <div class="col-12 text-center text-corporate-color h2">
                        LinguaMeeting + Experiences
                    </div>

                </div>
            @endif
            <div class="row mt-4">

                <div class="col-12 text-center text-corporate-color h5">
                    {{$course->university->name}}
                </div>
                <div class="col-12 text-center text-deep-black ">
                    {{$course->university->country->name}} - {{$course->university->timezone->name}}
                </div>
            </div>

            <div class="row mt-5">

                <div class="col-12 py-2 mb-2 rounded bg-corporate-color-light" style="background-color: rgba(53, 180, 180,0.2)">
                    <div class="row">
                        <div class="col-6 col-md-7 col-lg-6 text-start ">
                            <span class="text-corporate-dark-color fw-bold">Price per student</span>
                        </div>
                        <div class="col-6 col-md-5 col-lg-6">
                            <span class="fst-italic">{{$linguaMoney->format($course->price())}}</span>

                            @if( $course->hasDiscount())
                                <span class="fst-italic">(applied discount -{{$linguaMoney->format($course->discount)}})</span>
                            @endif
                        </div>
                    </div>
                </div>


                @if ($course->hasFree())
                    <div class="col-12 py-2 mb-2" style="background-color: #eee">
                        <div class="row rounded">
                            <div class="col-6 col-md-7 col-lg-6 text-start">
                                <span class="text-corporate-dark-color fw-bold">Open access</span>
                            </div>
                            <div class="col-6 col-md-5 col-lg-6">
                                @if ($course->isFree())
                                    <span class="d-block fst-italic">{{$course->isFree() ? 'Yes' : ''}}</span>
                                @endif
                                @if (!$course->isFree() AND $course->hasSectionFree())
                                    <span class="d-block">Only for: </span>
                                    <ul>
                                        @foreach ($course->section as $section)
                                            @if ($section->isFree())
                                                <li>{{$section->name}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif


                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12 py-2 mb-2" style="background-color: #eee">
                    <div class="row rounded">
                        <div class="col-6 col-md-7 col-lg-6 text-start">
                            <span class="text-corporate-dark-color fw-bold">Holidays</span>
                        </div>
                        <div class="col-6 col-md-5 col-lg-6">
                            @if ($course->holiday->count())
                                {{ $course->holiday->implode(function ($holiday){return toDate($holiday->date);},', ') }}
                            @else
                                <span class="fst-italic">No holidays</span>
                            @endif

                        </div>
                    </div>
                </div>

                @include('admin.course.coaching-form.course-summary.info_element', ['title' => 'Language', 'value' => $course->language->name])

                @if ($course->hasComplimentaryMakeup())
                    @include('admin.course.coaching-form.course-summary.info_element', [
                                'title' => 'Complimentary make-up',
                                'value' => $course->complimentary_makeup ? 'Yes' : 'No'
                                ])
                @endif


                @include('admin.course.coaching-form.course-summary.info_element', [
                                'title' => 'Make-ups available to students for purchase',
                                'value' => $course->printMakeupsNumber()
                                ])



                <div class="col-12 mt-2 py-2 mb-2 rounded bg-corporate-color-light text-center">
                    <div class="row rounded">

                        <div class="col-6 col-md-7 col-lg-6 text-start">
                            <span class="text-corporate-dark-color fw-bold">Canvas Course ID:</span>
                        </div>
                        <div class="col-6 col-md-5 col-lg-6">

                        @if($course->isActive())
                        <input class="form-control" type="text" value="{{$canvas_id}}" />
                        <a type="button" class="btn bg-text-corporate-color mt-2 colorWhite">
                            Save
                        </a>
                        @else
                        <span class="fst-italic">{{$canvas_id}}</span>
                        @endif
                        </div>

                    </div>

                </div>
                <div class="col-12 mt-4 py-2 mb-2 rounded text-center">
                    <a href="{{route('get.admin.course.section.coaching_form.file.download_summary', $course->id)}}"
                       title="Downlad course summary"
                       class="btn btn-primary btn-sm fw-bold px-4 " type="submit">
                        <i class="fa fa-download me-2"></i> Download Summary
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

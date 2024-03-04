<div class="row">
    <div class="col-12">
        <div class="card p-3">


            <div class="row">
                <div class="col-12">
                    <span class="h4 me-3 text-corporate-dark-color">LinguaMeeting Course Summary</span>
                    <a href="{{route('get.admin.course.coaching_form_experiences.create.academic_dates', $course->id)}}"
                       class="small"
                       title="Edit Academic Dates">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center text-corporate-color">
                    <span class="d-block h5">{{$course->name}}</span>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12 text-center text-corporate-color">
                    <span class="d-block h6">{{$course->semester->name}}, {{$course->year}}</span>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center subtitle-color">
                    <span class="h6">
                        {{$course->start_date->format('m/d/Y')}} - {{$course->end_date->format('m/d/Y')}}
                    </span>

                    <a href="{{route('get.admin.course.coaching_form_experiences.create.update.academic_dates', $course->id)}}"
                       class=" h6 small"
                       title="Edit Academic Dates">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
            </div>

            <div class="row mt-4">

                <div class="col-12 text-center text-corporate-color h2">
                    Live Experiences
                </div>

            </div>


            <div class="row mt-4">

                <div class="col-12 text-center text-corporate-color h6">
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

                @include('admin.course.coaching-form.course-summary.info_element', ['title' => 'Language', 'value' => $course->language->name])

                <div class="col-12 mt-4 py-2 mb-2 rounded text-center">
                    <a href="{{route('get.admin.course.section.coaching_form_experiences.file.download_summary', $course->id)}}"
                       title="Downlad course summary"
                       class="btn btn-primary btn-sm fw-bold px-4 " type="submit">
                        <i class="fa fa-download me-2"></i> Download Summary
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="row mt-5">
    <div class="col-xl-2">
        <img src="{{asset('assets/img/logo_experiences.png')}}" class="img-fluid w-75" />
    </div>
    <div class="col-xl-10 ">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <span class="d-block fw-bold">
                    {{toDayMonthAndYear($course->firstDate())}} - {{toDayMonthAndYear($course->lastDate())}}
                </span>
                <a href="{{route('get.student.experience.index')}}" class="d-block text-corporate-dark-color text-decoration-underline" title="View All Experiences">
                    View List
                </a>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    @if ($course->conversationPackage->hasExperiences())
                        [included in your package]
                    @else
                        [optional]
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row">

    @foreach ($experienceRegisters as $experienceRegister)
        @php $experience = $experienceRegister->experience @endphp
        @php $files = $experience->files() @endphp
        <div class="col-12 mt-3 shadow-sm">
            <div class="row border p-1 rounded">

                <div class="col-10">

                    <div class="row">
                        <div class="col-12">

                            <a href=""
                               class="d-block font-weight-bold text-corporate-dark-color"
                               data-bs-toggle="modal"
                               data-bs-target="#experience-id-{{$experience->hashId()}}"
                               title="Show Experience Info">
                                {{$experience->title}}
                            </a>

                            @include('common.modal_info', [
                                       'modalId' => 'experience-id-'.$experience->hashId(),
                                       'modalTitle' => 'Experience Info',
                                       'size' => 'modal-md',
                                       'path' => 'student.experience.modal_info',
                                       'experience' => $experience,
                                   ])

                            <span class="d-block small text-muted">
                        {{toDayDateTimeString($experience->start, $experienceTimezone)}} to {{toTime24h($experience->end, $experienceTimezone)}} ({{$experienceTimezone->name}})
                    </span>
                        </div>

                        <div class="col-12 mt-2 d-flex justify-content-between">
                            @if ($experience->isFuture($nowUTC)) {{-- register and future --}}

                                @if ($experience->studentCanBeJoin($student->timezone))
                                    <a href="{{route('get.student.experience.join', $experience->hashId())}}"
                                       class="join-experience fw-bold small text-decoration-underline text-corporate-dark-color"
                                       title="Join Experience">
                                        Join Experience
                                    </a>
                                @else
                                    <a href="#"
                                       class="fw-bold small p-1 d-block text-decoration-underline text-corporate-dark-color"
                                       onclick="return confirm('Sorry, you can only join the experience at the start time and before end time.');"
                                       title="Join Experience">
                                        Join Experience
                                    </a>
                                @endif

                            @else {{-- register and past --}}

                                @if ($experience->hasRecording())
                                    <a href="{{$experience->zoom_video}}"
                                       target="_blank"
                                       class="me-3 small"
                                       title="View Recording">
                                        View Recording
                                    </a>
                                @else
                                    <a href="#"
                                       target="_blank"
                                       class="me-3 small"
                                       title="Wait Recording">
                                        Wait Recording...
                                    </a>
                                @endif

                                @if ($experience->userAttendance($student))

                                    <a href="{{route('get.experience.comment.create', $experience->hashId())}}"
                                       class="open-modal small"
                                       data-modal-reload="yes"
                                       data-modal-size="modal-lg"
                                       data-reload-type="parent"
                                       data-modal-title="Comment a Experience"
                                       title="Comment a Experience">
                                        Rate this experience
                                    </a>

                                @endif
                            @endif

                            @if ($files->hasVocabularyFile())
                                <a href="{{route('get.experience.file.download', $files->vocabularyFile()->hashId())}}"
                                   class="small"
                                   title="Download Vocabulary">
                                    <i class="fa fa-download"></i> Vocabulary List
                                </a>
                            @endif


                        </div>
                    </div>
                </div>

                <div class="col-2 d-flex align-items-center justify-content-center">

                    @if ($experience->isDonate())

                        <a href="{{route('get.experience.tip.create', [$experience->hashId(),$student->hashId()])}}"
                           class="open-modal small"
                           data-modal-reload="yes"
                           data-modal-size="modal-lg"
                           data-modal-height="h-90"
                           data-reload-type="parent"
                           data-modal-title="Leave a tip"
                           title="Leave a tip">
                            <img src="{{asset('assets/img/logo_donate_web.png')}}" class="ms-2" width="40px"/>
                        </a>

                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>




@php $files = $experience->files() @endphp

<div class="row gx-0 p-3 mb-4 border rounded shadow-sm">
    <div class="col-12 col-md-7">

        <div class="row">
            <div class="col-12">
                <i class=" fa fa-calendar-day text-corporate-color me-2"></i>
                <span class="fw-bold">
                    {{toDayDateTimeString($experience->start, $timezone)}} to {{toTime24h($experience->end, $timezone)}} ({{$timezone->name}})
                </span>
            </div>

            <div class="col-12 mt-2">
                <i class=" fa fa-tag fa-fw text-corporate-color me-2"></i>
                <span class="text-corporate-dark-color fw-bold">{{$experience->title}}</span>
            </div>

            <div class="col-12 mt-2">
                <i class=" fa fa-street-view fa-fw text-corporate-color me-2"></i>
                <span class=" fw-bold">Host: {{$experience->coach->writeFullName()}}</span>
            </div>

            <div class="col-12 mt-2">
                <i class=" fa fa-language fa-fw text-corporate-color me-2"></i>
                <span class=" fw-bold">Language: {{$experience->language->name}}</span>
            </div>

            @if ($experience->level)
                <div class="col-12 mt-2">
                    <i class=" fa fa-level-up-alt fa-fw text-corporate-color me-2"></i>
                    <span class=" fw-bold">Level: {{$experience->level->name}}</span>
                </div>
            @endif

            @if ($experience->isPaidPrivate() AND $mustPayForExperiences)
                <div class="col-12 mt-2">
                    <i class=" fa fa-language text-corporate-color me-2"></i>
                    <span class=" fw-bold">Price: {{format_money($experience->price)}}</span>
                </div>
            @endif

            <div class="col-12 mt-3">
                {!! $experience->description !!}
            </div>

            <div class="col-12 mt-3 d-flex justify-content-between">
                <div>

                    @if ($experience->userIsRegistered($user))

                        @if ($experience->isFuture($nowUTC)) {{-- register and future --}}

                            @if ($experience->studentCanBeJoin($user->timezone))
                                <a href="{{route('get.student.experience.join', $experience->hashId())}}"
                                   class="btn bg-corporate-color text-white join-experience"
                                   title="Join Experience">
                                    Join Experience
                                </a>
                            @else
                                <a href="#"
                                   class="btn bg-gray text-white border-1 rounded small p-1 d-block"
                                   onclick="return confirm('Sorry, you can only join the experience at the start time and before end time.');"
                                   title="Join Experience">
                                    Join Experience
                                </a>
                            @endif

                        @else {{-- register and past --}}

                            @if ($experience->hasRecording())
                                <a href="{{$experience->zoom_video}}"
                                   target="_blank"
                                   class="btn bg-corporate-color text-white me-3"
                                   title="View Recording">
                                    View Recording
                                </a>
                            @else
                                <a href="#"
                                   target="_blank"
                                   class="btn bg-gray text-white me-3"
                                   title="Wait Recording">
                                    Wait Recording...
                                </a>
                            @endif

                            @if ($experience->userAttendance($student))

                                <a href="{{route('get.experience.comment.create', $experience->hashId())}}"
                                   class="open-modal text-corporate-dark-color text-decoration-underline fw-bold"
                                   data-modal-reload="yes"
                                   data-modal-size="modal-lg"
                                   data-reload-type="parent"
                                   data-modal-title="Comment a Experience"
                                   title="Comment a Experience">
                                    <i class="fa fa-star"></i> Rate this experience
                                </a>

                            @endif
                        @endif

                    @else {{-- user not registered --}}

                        @if ($experience->isFuture($nowUTC)) {{-- register and future --}}
                            @if ($mustPayForExperiences)

                                <a href="{{route('get.experience.register.payment', $experience->hashId())}}"
                                   class="open-modal btn bg-corporate-color text-white border-1 rounded small p-1 d-block"
                                   data-modal-reload="yes"
                                   data-modal-size="modal-lg"
                                   data-modal-height="h-95"
                                   data-reload-type="parent"
                                   data-modal-title="Register in experience"
                                   title="Register in experience">
                                    Register
                                </a>

                            @else

                                <a href="{{route('get.experience.register.free', $experience->hashId())}}"
                                   class="open-modal btn bg-corporate-color text-white border-1 rounded small p-1 d-block"
                                   data-modal-reload="yes"
                                   data-modal-size="modal-md"
                                   data-reload-type="parent"
                                   data-modal-title="Register in experience"
                                   title="Register in experience">
                                    Register
                                </a>

                            @endif
                        @endif
                    @endif
                </div>

                <div>

                    @if ($experience->isDonatePrivate())
                        <a href="{{route('get.experience.tip.create', [$experience->hashId(), $instructor->hashId()])}}"
                           class="open-modal btn border-1 rounded small p-0 text-corporate-dark-color fw-bold"
                           data-modal-reload="yes"
                           data-modal-size="modal-lg"
                           data-modal-height="h-90"
                           data-reload-type="parent"
                           data-modal-title="Leave a tip"
                           title="Leave a tip">
                            <span class="text-decoration-underline">Leave a tip</span> <img src="{{asset('assets/img/logo_donate_web.png')}}" class="ms-2" width="40px"/>
                        </a>
                    @endif
                </div>

            </div>

            <div class="col-12 mt-4 d-flex justify-content-between">

                @if ($files->hasVocabularyFile())
                    <a href="{{route('get.experience.file.download', $files->vocabularyFile()->hashId())}}"
                       title="Download Vocabulary">
                        <i class="fa fa-download fa-fw"></i> Useful vocabulary list
                    </a>
                @endif

                @if ($registerList->canDeleteRegisterNow($experience, $nowUTC))
                    <a href="{{route('get.experience.register.delete', $experience->hashId())}}"
                       onclick="return confirm('Are you sure to remove your assitence to this experience?');"
                       class="text-corporate-danger">
                        <i class="fa fa-times me-1"></i> Delete Register
                    </a>
                @endif


            </div>
        </div>
    </div>

    <div class="col-12 col-md-5">

        @if ($files->hasBannerFile(1))
            <img src="{{asset($files->bannerFile(1)->path()->get())}}" class="img-thumbnail"/>
        @else
            <span class="text-muted">Experience has not image</span>
        @endif
    </div>
</div>

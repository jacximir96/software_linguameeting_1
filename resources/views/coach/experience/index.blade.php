@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-photo-video me-1"></i>
                Experiences
            </span>
            <span>{{$experienceTimezone->name}}</span>
        </div>
        <div class="card-body col-xl-8 offset-xl-2">

            @foreach ($experiences as $experience)
                @php $files = $experience->files() @endphp

                <div class="row border rounded mb-4 p-2">

                    <div class="col-7">

                        <div class="row">

                            <div class="col-12">
                                <i class=" fa fa-calendar-day text-corporate-color me-2"></i>
                                <span class="fw-bold">{{toDayDateTimeString($experience->start, $experienceTimezone) }} to
                                    {{toTime24h($experience->end, $experienceTimezone)}} ({{$experienceTimezone->name}})</span>
                            </div>

                            <div class="col-12 mt-2">
                                <span class="text-corporate-dark-color fw-bold">{{$experience->title}}</span>
                            </div>

                            <div class="col-12 mt-2">
                                {!! $experience->description !!}
                            </div>

                            <div class="col-12 mt-2 d-flex justify-content-between">

                                @if ($experience->hasRecording())

                                    <a href="{{$experience->zoom_video}}"
                                       target="_blank"
                                       class="btn btn-xs bg-primary text-white"
                                       title="View Recording">
                                        <i class="fa fa-eye"></i> View Recording
                                    </a>

                                @else
                                    <span class="text-corporate-danger">Recording not available</span>
                                @endif

                                @if ($files->hasVocabularyFile())
                                    <a href="{{route('get.experience.file.download', $files->vocabularyFile()->hashId())}}"
                                        title="Download Vocabulary">
                                        <i class="fa fa-download"></i> Vocabulary
                                    </a>
                                @endif


                                <a href="{{$experience->url_join}}"
                                   target="_blank"
                                   class="btn btn-xs bg-warning text-dark"
                                   title="Url Join">
                                    <i class="fa fa-play"></i> Start
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-5">

                        @if ($files->hasBannerFile(1))
                            <img src="{{asset($files->bannerFile(1)->path()->get())}}" class="img-thumbnail"/>
                        @else
                            <span class="text-muted">Experience has not image</span>
                        @endif
                    </div>

                </div>

            @endforeach

            {{$experiences->render()}}
        </div>


    </div>
@endsection

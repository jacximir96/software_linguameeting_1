<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')


<main>

    <section>

        <div class="paddingSection">


            <div class="boxSelectedExp">

                <div class="row">

                    <div class="col-md-6 text-70 colorBase1">
                        {!! $experience->title !!}
                    </div>

                    <div class="col-md-6">

                        <div class="text_right margin-top10">
                            @if ($files->hasBannerFile(2))
                                <img src="{{asset($files->bannerFile(2)->path()->get())}}" class="imgboxSelectedExp" alt="Image of {{$experience->title}}"/>
                            @else
                                <span class="text-muted">Experience has not image</span>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="row margin-top40 colorBase2">
                    <div class="col-md-12 text-26 fontRecoleta w500">
                        Explore
                    </div>
                </div>

                <div class="row margin-top20">

                    <div class="col-md-6 text-18 colorBase1 w500">

                        <div class="line_height">
                            {!! $experience->description !!}
                        </div>

                        @if ($experience->isFuture($now))
                            <div class="margin-top20">

                                <a href="{{route('get.public.experience.book.create', $experience->hashId())}}"
                                   class="open-modal d-block btnBasicRed cursor_pointer text-white"
                                   data-modal-reload="yes"
                                   data-modal-size="modal-lg"
                                   data-modal-height="h-90"
                                   data-reload-type="parent"
                                   data-modal-title="Book Experience"
                                   title="Book Experience">
                                    <span class="text-decoration-underline">Book</span>
                                </a>

                            </div>
                        @endif

                        <div class="margin-top20">

                            <a href="{{route('get.public.experience.rate.create', $experience->hashId())}}"
                               class="open-modal d-block btnBasicWhiteLongGreen cursor_pointer"
                               data-modal-reload="yes"
                               data-modal-size="modal-lg"
                               data-modal-height="h-90"
                               data-reload-type="parent"
                               data-modal-title="Rate Experience"
                               title="Rate Experience">
                                <span class="text-decoration-underline">Rate this experience</span>
                            </a>
                        </div>

                        @if ($experience->isDonatePublic())
                            <div class="row margin-top20">
                                <div class="text-20 col-md-4 col-xs-12 cursor_pointer margin-top10 margin_auto">
                                    <a href="{{route('get.public.experience.tip.create', $experience->hashId())}}"
                                       class="open-modal d-block btnBasicRed cursor_pointer text-white font-weight-normal"
                                       data-modal-reload="yes"
                                       data-modal-size="modal-lg"
                                       data-modal-height="h-90"
                                       data-reload-type="parent"
                                       data-modal-title="Leave a Tip"
                                       title="Leave a Tip">
                                        <span class="text-decoration-underline">Leave a tip</span>
                                    </a>
                                </div>
                                <div class="text-20 col-md-8 col-xs-12 text_left">
                                    <img src="{{asset('assets/img/logo_donate_web.png')}}" class="imgDonate"/>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="col-md-6 text-18 colorBase1">

                        <div class="text_right">
                            <img class="" src="{{asset('assets/img/web/expIcon09.png')}}" alt="Icon Experience">
                        </div>
                        <div class="text_right margin-top10">
                            {{toFormattedDayDateString($experience->start, $timezone->name)}}
                        </div>
                        <div class="text_right margin-top10">
                            {{toTime24h($experience->start, $timezone->name)}} to {{toTime24h($experience->end, $timezone->name)}} ({{$timezone->simplifiedName()}})
                        </div>
                        <div class="text_right margin-top10">
                            <strong>Host: </strong>{{$experience->coachName()}}
                        </div>
                        <div class="text_right margin-top10">
                            <strong>Language: </strong> {{$experience->language->name}}
                        </div>
                        @if ($experience->level)
                            <div class="text_right margin-top10">
                                <strong>Level: </strong> {{$experience->level->name}}</span>
                            </div>
                        @endif

                        @if ($experience->showPrice($now))
                            <div class="text_right margin-top10">
                                <strong>Cost: </strong> {{format_money($experience->price)}}
                            </div>
                        @elseif($experience->showFree($now))
                            <div class="text_right margin-top10">
                                <strong>Cost: </strong>Free
                            </div>
                        @endif

                        @if ($files->hasVocabularyFile())
                        <div class="text_right margin-top10 fontRecoleta">
                            <a href="{{route('experiences.vocabulary.download', $files->vocabularyFile()->hashId())}}"
                               class="colorBase2">
                                <strong>Download Vocabulary</strong>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('common.web.footer')
@include('web.layout.modal')
</body>
</html>

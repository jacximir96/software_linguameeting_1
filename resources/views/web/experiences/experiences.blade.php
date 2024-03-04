<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>

    <section id="section1_exp">

        <div class="section1_exp paddingSection">

            <div class="row">

                <div class="col-md-6">

                    <div class="position_relative">
                        <img src="{{asset('assets/img/web/coach_experience.png')}}" alt="Coach experience">

                        <div class="divAbsLogoPlayExp cursor_pointer">
                            <a href="https://www.youtube.com/watch?v=xK_PhV9DUCA" target="_blank" title="Coach experience video">
                                <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>
                    </div>


                </div>


                <div class="col-md-6">

                    <div class="colorBase1 w500">
                        CULTURE CANNOT BE LEARNED; IT HAS TO BE EXPERIENCED
                    </div>

                    <div class="fontRecoleta colorBase1 text-72 line_height1 margin-top20">
                        <span class="colorBase2">Live</span> cultural presentations from all over the world<span class="colorBase2">—all year long!</span>
                    </div>


                </div>


            </div>


        </div>


    </section>

    <section id="section1b_exp">

        <div class="section1b_exp" title="Experience graphic">

            <div class="row">

                <div class="col-md-6">

                    <div class="text-21 colorBase1 line_height margin-top60">

                        <p>
                            <strong>Experiences are hosted by LinguaMeeting coaches</strong>, held on Zoom, and offer diverse cultural opportunities in the target language.
                        </p>

                        <p>
                            These live events, tailored to the needs of language learners, are a quick and easy way to add a fun, low-stakes cultural immersion experience to your course.
                        </p>

                        <div>
                            <a href="{{route('register')}}" alt="Sign Me Up">
                                <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600">
                                    Sign Me Up
                                </div>
                            </a>
                        </div>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="text-18 line_height marginTopMedia">

                        <div class="row">
                            <div class="col-md-4 text_right">
                                <img src="{{asset('assets/img/web/Learn-Icon.png')}}" alt="Learn icon">
                            </div>

                            <div class="col-md-8">

                                <div class="colorBase2 fontRecoleta text-26 w500">
                                    Learn
                                </div>

                                <div class="colorBase1 margin-top20 text-18">
                                    <strong>Level-appropriate presentations</strong> that are designed with first- and second-year language learners in mind
                                </div>

                            </div>
                        </div>

                        <div class="row margin-top40">
                            <div class="col-md-4 text_right">
                                <img src="{{asset('assets/img/web/explore.png')}}" alt="Explore icon">
                            </div>

                            <div class="col-md-8 ">

                                <div class="colorBase2 fontRecoleta text-26 w500">
                                    Explore
                                </div>

                                <div class="colorBase1 margin-top20 text-18">
                                    <strong>À la carte or unlimited access</strong> to diverse cultural opportunities in the target language
                                </div>

                            </div>
                        </div>

                        <div class="row margin-top40">
                            <div class="col-md-4 text_right">
                                <img src="{{asset('assets/img/web/connect.png')}}" alt="Connect icon">
                            </div>

                            <div class="col-md-8 ">

                                <div class="colorBase2 fontRecoleta text-26 w500">
                                    Connect
                                </div>

                                <div class="colorBase1 margin-top20 text-18">
                                    <strong>Authentic cultural explorations</strong> hosted and personalized by local LinguaMeeting coaches
                                </div>

                            </div>
                        </div>


                    </div>


                </div>


            </div>


        </div>


    </section>

    <section id="section5_exp">

        <div class="section5_exp">
            <div class="row margin-top40">

                <div class="col-md-12 text_center">

                    <div class="testimonialsCarouselDiv">
                        <div class="testimonialsCarousel slider">
                            <div class="languageSlideWidth colorBase1">


                                <div class="colorBase1 w500 line_height text-28">
                                    It was so neat to just see someone walking down the alley singing and playing the guitar, or to see a group of children skating downtown! These are things you would
                                    not see here and it is fun to observe. Learning about the history of Spain and all of the influences on Spanish culture was also wonderful.
                                </div>

                                <div class="colorBase1 w400 text-16 margin-top20">
                                    ABIGAIL BENDER
                                </div>

                                <div class="colorBase1 w500 text-16">
                                    <strong>Texas Tech Universilty</strong>
                                </div>
                            </div>

                            <div class="languageSlideWidth colorBase1">

                                <div class="colorBase1 w500 text-28">
                                    This was so interesting! I learned about the native dances, and the cultural and ecological facets to Honduras. I especially loved learning about the animals in the
                                    national park. Those were some great vocabulary words! I was surprised at how much of the presentation I understood and was able to comprehend. I even took notes in
                                    Spanish and I spelled most of the words correctly!
                                </div>

                            </div>

                        </div>

                    </div>


                </div>

            </div>


            <div class="row">

                <div class="col-md-12 text_center colorWhite text-23 margin-bottom20">

                    <div class="btnBasicWhiteLongGreen w600 margin_auto">
                        <a href="{{url('testimonials/students')}}" class="colorBase2">

                            View Testimonials

                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="section2_exp" name="experiences_section">

        <div class="paddingSection">

            <div class="text_center fontRecoleta colorBase1 text-32">
                <div class="btn-group borderBottomText">

                    @if ($time == 'past')
                        <div class="">Past Experiences</div>
                    @elseif ($time == 'upcoming')
                        <div class="">Upcoming Experiences</div>
                    @else
                        <div class="">All Experiences</div>
                    @endif

                    <div class="cursor_pointer colorBase2 w300 marginArrowExp" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item colorBase1 text-32" href="{{route('experiences', ['time' => 'all'])}}?#experiences_section" title="All Experiences">All Experiences</a>
                        <a class="dropdown-item colorBase1 text-32" href="{{route('experiences', ['time' => 'past'])}}?#experiences_section" title="Past Experiences">Past Experiences</a>
                        <a class="dropdown-item colorBase1 text-32" href="{{route('experiences', ['time' => 'upcoming'])}}?#experiences_section" title="Upcoming Experiences">Upcoming Experiences</a>
                    </div>
                </div>


            </div>

            <div class="margin-top40">

                @if ($experiences->count() == 0)
                    <h2 class="color4 text_center margint-top40"><strong>New Experiences Coming Soon </strong></h2>
                @endif

                @foreach ($experiences->take(3) as $experience)

                    @php $files = $experience->files() @endphp

                    <div class="boxExperience clear_both row margin-top20">

                        <div class="float_left divBannerExp15">
                            @if ($files->hasBannerFile(2))
                                <img src="{{asset($files->bannerFile(2)->path()->get())}}" class="imgHeightExperience" alt="Image of {{$experience->title}}"/>
                            @else
                                <span class="text-muted">Experience has not image</span>
                            @endif
                        </div>

                        <div class="row float_left divInfoExp85">

                            <div class="col-lg-9 colorBase1">
                                <div class="text-32 padding-top20 padding-left10">
                                    {{$experience->title}}
                                </div>
                                <div class="text-18 colorBase2 padding10">
                                    <strong>{{toFormattedDayDateString($experience->start, $timezone->name)}}</strong>
                                </div>

                                <div class="text-18 w500 padding-left10 padding-right10">
                                    {{toTime24h($experience->start, $timezone->name)}} to {{toTime24h($experience->end, $timezone->name)}} ({{$timezone->simplifiedName()}})
                                </div>
                            </div>

                            <div class="col-lg-3 text_right">

                                <div class="colorBase1 text-18 padding-right20 padding-top20">
                                    <strong>Cost:</strong>

                                    @if ($experience->hasPrice())
                                        <span class="w400 text-32">{{format_money($experience->price)}}</span>
                                    @elseif($experience->showFree($now))
                                        <span class="w400 text-32">Free</span>
                                    @endif
                                </div>

                                <div class="float_right padding-right20">
                                    <a href="{{route('experiences.show', $experience->hashId())}}" title="Show Experience {{$experience->title}}">
                                        <div class="btnBasicTransparent textBtnLearnMore margin-top20 w600">
                                            Learn More
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach


                <div class="margin-top40 w600 text_center text-18">
                    @if ($experiences->count() > 3)
                        <a class="colorBase2 borderBottomText" onclick="modalViewMoreExp();">
                            View More
                        </a>
                    @endif
                </div>

            </div>

        </div>


    </section>


    <section id="section3_exp">

        <div class="section3_exp">

            <div class="mediumCircleWhite text_center">

                <div class="colorBase4 w600 margin-top40">
                    FOR INSTRUCTORS
                </div>

                <div class="colorBase1 text-32 fontRecoleta margin-top20">
                    <span class="borderBottomText"> How to Implement</span>
                </div>

            </div>


            <div class="row boxSteps1">
                <div class="col-md-12 w500 text_center">
                    <div>
                        <div class="margin-top20">OPTION No. 1:</div>
                        <div class="fontRecoleta text-32 margin-top10 margin-bottom10">
                            A required part of your course

                        </div>

                    </div>

                    <div class="float-right text-28 arrowCollapse">
                        <i class="fas fa-chevron-down cursor_pointer colorWhite"
                           data-toggle="collapse" href="#Step1" role="button" aria-expanded="false" aria-controls="Step1"
                           data-fa-i2svg="" onclick="changeArrow('step1ArroyList');" id="step1ArroyList">

                        </i>
                    </div>

                </div>
            </div>

            <div class="collapse" id="Step1">

                <div class="paddingSection">

                    <div class="colorBase1 text-22 line_height">
                        <ul class="ulListNew">
                            <li>
                                Select the Experiences add-on when filling out the LinguaMeeting coaching form.
                            </li>

                            <li class="padding-top40">
                                Determine the number of Experiences for course attendance. Students can choose the Experiences topics that interest them most.
                            </li>

                            <li class="padding-top40">
                                <strong>Unlimited access throughout the semester:</strong> $15
                            </li>
                        </ul>
                        <div>
                            <a href="{{url('register')}}" title="Sign Me Up">
                                <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600 margin_auto">
                                    Sign Me Up
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

            </div>


            <div class="row boxSteps2Color">
                <div class="col-md-12 w500 text_center">
                    <div>
                        <div class="margin-top20">OPTION No. 2:</div>
                        <div class="fontRecoleta text-32 margin-top10 margin-bottom10">
                            Extra Credit

                        </div>

                    </div>

                    <div class="float-right text-28 arrowCollapse">
                        <i class="fas fa-chevron-down cursor_pointer colorWhite"
                           data-toggle="collapse" href="#Step2" role="button" aria-expanded="false"
                           aria-controls="Step2" data-fa-i2svg="" onclick="changeArrow('step2ArroyList');" id="step2ArroyList">

                        </i>
                    </div>

                </div>
            </div>

            <div class="collapse" id="Step2">

                <div class="paddingSection">

                    <div class="colorBase1 text-22 line_height">
                        <ul class="ulListNew">
                            <li>
                                Your students will have access to all Experiences throughout the semester, through the LinguaMeeting portal.

                            </li>

                            <li class="padding-top40">
                                Track participation and view recordings.

                            </li>

                            <li class="padding-top40">
                                <strong>À la carte access throughout the semester: Tip-supported or $5/each</strong>
                            </li>
                        </ul>
                        <div>
                            <a href="{{url('register')}}" title="Sign Me Up">
                                <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600 margin_auto">
                                    Sign Me Up
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

            </div>


            <div class="row boxSteps3White">
                <div class="col-md-12 w500 text_center">
                    <div>
                        <div class="margin-top20">OPTION No. 3:</div>
                        <div class="fontRecoleta text-32 margin-top10 margin-bottom10">
                            Offered but optional

                        </div>

                    </div>

                    <div class="float-right text-28 arrowCollapse">
                        <i class="fas fa-chevron-down cursor_pointer colorBase2"
                           data-toggle="collapse" href="#Step3" role="button" aria-expanded="false" aria-controls="Step3"
                           data-fa-i2svg="" onclick="changeArrow('step3ArroyList');" id="step3ArroyList">

                        </i>
                    </div>

                </div>
            </div>

            <div class="collapse" id="Step3">

                <div class="paddingSection">

                    <div class="colorBase1 text-22 line_height">
                        <ul class="ulListNew">
                            <li>
                                Anyone can access, you don't have to be enrolled in school.
                            </li>

                            <li class="padding-top40">
                                No need for faculty to complete any form or create course.
                            </li>

                            <li class="padding-top20">
                                Share this site with your students so they can book their Experiences.
                            </li><!-- comment -->

                            <li class="padding-top20">
                                No access to portal to track students' attendance.
                            </li>

                            <li class="padding-top20">
                                <strong>À la carte access throughout the semester: Tip-supported or $5/each</strong>
                            </li>
                        </ul>

                        <div>
                            <a href="{{url('register')}}" title="Sign Me Up">
                                <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600 margin_auto">
                                    Sign Me Up
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>

        <div class="paddingSection">

            <div class="row">

                <div class="col-md-12 colorBase1">

                    <div class="text-54 colorBase2 fontRecoleta text_center line_height1">
                        Instructors who opt in for <span class="colorBase1">Experiences</span> can:
                    </div>

                    <div class="margin-top40 w500 text_center line_height">
                        <div class="boxSquareExpBenWhiteSmall colorBase1 w500">
                            <div class="text_center">
                                <img src="{{asset('assets/img/web/LinguaMeeting-Difference-Icon-Cultural-Appreciation.png')}}" alt="icon experience" class="margin-right10">
                                Give their students a choice of cultural topics that interest them, different from what is found in their textbook.
                            </div>
                        </div>

                        <div class="boxSquareExpBenWhiteSmall colorBase1 w500">
                            <div class="text_center">
                                <img src="{{asset('assets/img/web/LinguaMeeting-Difference-Icon-Flexible.png')}}" alt="icon experience" class="margin-right10">
                                Monitor student attendance from the instructor portal.
                            </div>
                        </div>

                        <div class="boxSquareExpBenWhiteSmall colorBase1 w500">
                            <div class="text_center">
                                <img src="{{asset('assets/img/web/LinguaMeeting-Difference-Icon-Cost-Effective.png')}}" alt="icon experience" class="margin-right10">
                                Access and participate in all Experiences from the instructor portal at no cost.
                            </div>
                        </div>
                    </div>

                    <div class="btnBasicWhite w600 margin_auto margin-top20">
                        <a href="documents/web/Decreasing-Foreign-Language-Anxiety.pdf" target="_blank" class="colorBase2" title="Decreasing Foreign Language Anxiety">
                            View Study
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section id="section4_exp">

        <div class="paddingSection section4_exp">


            <div class="paddingBoxExp">
                <div class="row">

                    <div class="col-md-8">

                        <div class="fontRecoleta text-47 colorBase1 line_height1 position_relative zIndex100">
                            <span class="colorBase2">Your students will <br>rave</span> about their <br>new window to <br>the world.
                        </div>

                        <div class="text-21 margin-top10 colorBase1 position_relative zIndex100 line_height w500">
                            Connect your students to
                            <br>Spanish-speaking communities
                            <br>around the world!
                        </div>

                        <div class="btnBasicTransparent textBtnLearnMore margin-top20 w600 position_relative zIndex100">
                            <a href="{{url('register')}}" title="Sign Me Up" class="colorBase4">
                                Sign Me Up
                            </a>
                        </div>
                    </div>


                </div>

                <div class="imagExpBoxBorder">
                    <img src="{{asset('assets/img/web/twoPersonsExp.png')}}" alt="Two persons experience">
                </div>


                <div class="row margin-top40">

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon01.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top40">
                                Connecting with <br><strong>real people</strong> and <br><strong>real experiences</strong>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBen colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon02.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top20">
                                The benefits <br>of Live <br>Experiences
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon03.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top40">
                                Broadened <br>vocabulary and <br>grammar exposure
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon04.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top40">
                                Easy way to add <br>additional <br><strong>listening practice</strong>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon05.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top40">
                                Appreciation of <br>cultural norms <br>and practices
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon06.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top20">
                                The <strong>"live"</strong> aspect, <br>which keeps <br>things lively <br>and up to date!
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon07.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top40">
                                Vocabulary list provided to help students contextualize the experience
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-3 margin-top40">

                        <div class="boxSquareExpBenWhite colorBase1 w500 line_height">

                            <div class="text_center">
                                <img src="{{asset('assets/img/web/expIcon08.png')}}" alt="icon experience">
                            </div>

                            <div class="text_center margin-top20">
                                Language for <br>personal enjoyment <br>- inspiring lifelong <br>learning
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row margin-top20">
                </div>
            </div>
        </div>

    </section>

    <section id="section7_exp">

        <div class="section7_exp paddingSection">

            <div class="colorBase1 text-38 text_center line_height">
                Connect your students to Spanish-speaking communities <span class="colorBase2">around the world</span>!
            </div>

        </div>

    </section>


    <div id="modal_viewMoreExp" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header backgroundColor35b4b4 colorwhite">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body backgroundColorBase3">
                    @if ($time == 'past')
                        <h2 class="color4 text_center margint-top40"><strong>Past Experiences</strong></h2>
                    @elseif ($time == 'upcoming')
                        <h2 class="color4 text_center margint-top40"><strong>Upcoming Experiences </strong></h2>
                    @else
                        <h2 class="color4 text_center margint-top40"><strong>All Experiences </strong></h2>
                    @endif

                        @foreach ($experiences->skip(3) as $experience)
                    <div class="boxExperienceModal clear_both row margin-top20">

                        <div class="float_left divBannerExp15Modal">
                            @if ($files->hasBannerFile(2))
                                <img src="{{asset($files->bannerFile(2)->path()->get())}}" class="imgHeightExperience" alt="Image of {{$experience->title}}"/>
                            @else
                                <span class="text-muted">Experience has not image</span>
                            @endif

                        </div>


                            @php $files = $experience->files() @endphp
                            <div class="row float_left divInfoExp85Modal">

                                <div class="col-md-9 colorBase1">
                                    <div class="text-23 padding-top20 padding-left10">
                                        {{$experience->title}}
                                    </div>
                                    <div class="colorBase2 padding10">
                                        <strong>{{toFormattedDayDateString($experience->start, $timezone->name)}}</strong>
                                    </div>

                                    <div class="w500 padding-left10 padding-right10">
                                        {{toTime24h($experience->start, $timezone->name)}} to {{toTime24h($experience->end, $timezone->name)}} ({{$timezone->simplifiedName()}})
                                    </div>
                                </div>

                                <div class="col-md-3 text_right">

                                    <div class="colorBase1 padding-right20 padding-top20">
                                        <strong>Cost:</strong>
                                        <span class="w400 text-26">
                                            @if ($experience->hasPrice())
                                                {{format_money($experience->price)}}
                                            @elseif($experience->showFree($now))
                                                Free
                                            @endif
                                        </span>
                                    </div>

                                    <div class="float_right padding-right20 margin-top20">
                                        <a href="{{route('experiences.show', $experience->hashId())}}" title="Show Experience {{$experience->title}}">
                                            <div class="btnBasicTransparent textBtnLearnMore margin-top20 w600">
                                                Learn More
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>


                    </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>


</main>

@include('common.web.footer')

</body>
</html>

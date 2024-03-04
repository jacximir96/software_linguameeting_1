<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')

<main>

    <section id="section1">

        <div class="sectionMichelle">
            <div class="sayHello">
                <div class="colorBase2 line_height1">
                    Say hello to the
                    <br><span class="colorBase1">magic of language</span>
                    <br><span class="colorBase1">coaches</span>
                </div>

            </div>

            <div class="w500 realLife colorBase1 margin-top20">
                Real-Life Conversation Practice
            </div>

            <div class="realLifeFor colorBase1 zIndex100">
                <div class="float_right forStudent">
                    <a href="{{url('how-it-works/students')}}" class="colorBase1" title="How it works for students"><strong>For Students</strong></a>
                </div>

                <div class="float_right margin-right20 margin-left20 separatorDivRealLife">

                </div>

                <div class="float_right forInstructor">
                    <a href="{{url('how-it-works/instructors')}}" class="colorBase1" title="How it works for instructors"><strong>For Instructors</strong></a>
                </div>
            </div>

            <div class="realLifeForMedia colorBase1 zIndex100">
                <div class="row">

                    <div class="col-5">
                        <div class="text_right">
                            <a href="{{url('how-it-works/students')}}" class="colorBase1 borderBottomText padding-bottom5" title="How it works for students"><strong>For Students</strong></a>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="text_center margin_auto separatorDivRealLife">

                        </div>
                    </div>

                    <div class="col-5">
                        <div class="">
                            <a href="{{url('how-it-works/instructors')}}" class="colorBase1 borderBottomText padding-bottom5" title="How it works for instructors"><strong>For Instructors</strong></a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="divMichelle">

                <div>
                    <img class="imgMichelle" src="{{asset('assets/img/web/language-coach-cut-out.png')}}" alt="Coach Michelle">
                </div>

            </div>

            <div class="divCirculoMichelle">

                <div>
                    <img class="imgCirculoMichelle" src="{{asset('assets/img/web/circleCoachesBackground.png')}}" alt="Coach Michelle">
                </div>

            </div>
        </div>



    </section>

    <section id="section_2">

        <div class="paddingSection colorBase1" id="divReadyGet">
            <div class="row">

                <div class="col-md-5 divreadySign w600">
                    <div class="line_height">
                        Ready to get your
                        <br>students chatting?
                    </div>
                    <a href="{{route('register')}}" title="Sign Me up">
                        <div class="btnBasicTransparent w600 btnReady">
                            Sign Me Up
                        </div>
                    </a>
                </div>

                <div class="col-md-2">

                    <div class="separatorVertical">

                    </div>
                </div>

                <div class="col-md-5 divAnxiety w400">
                    Our friendly language coaches are experts at guiding <span class="colorBase4">low-anxiety conversations</span> with language learners, from true beginners on up.
                </div>

            </div>
        </div>


        <div class="paddingSection colorBase1" id="divReadyGetMedia">


            <div class=" divAnxiety w400 text_center">
                Our friendly language coaches are experts at guiding <span class="colorBase4">low-anxiety conversations</span> with language learners, from true beginners on up.
            </div>

            <div class="">

                <div class="separatorHorizontalMedia">

                </div>
            </div>

            <div class="divreadySign w600">
                <div class="line_height">
                    Ready to get your
                    <br>students chatting?
                </div>
                <a href="{{route('register')}}" title="Sign Me Up">
                    <div class="btnBasicTransparent w600 btnReady">
                        Sign Me Up
                    </div>
                </a>
            </div>

        </div>


    </section>

    <section id="section_3">

        <div class="twoGuys">

            <div class="row">

                <div class="col-md-12 guyFirstSession" title="Students learning sesions">

                    <div class="divgGuyLogoPlay cursor_pointer">
                        <a href="{{asset('assets/video/1vs12corto.mp4')}}" target="_blank" title="How learn students">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Outlined.png')}}" alt="Play Logo">
                        </a>
                    </div>

                </div>


            </div>


        </div>


    </section>

    <section id="section_4">

        <div class="section_4">

            <div class="languages9 w600">
                9 Languages - <span class="borderRed">Unlimited Possiblilities</span>
            </div>

            <div class="fontRecoleta divCarouselLanguages centerCarousel slider">
                <div class="languageSlideWidth colorBase1">Spanish</div>
                <div class="languageSlideWidth colorBase1">French </div>
                <div class="languageSlideWidth colorBase1">Italian</div>
                <div class="languageSlideWidth colorBase1">Portuguese</div>
                <div class="languageSlideWidth colorBase1">Russian</div>
                <div class="languageSlideWidth colorBase1">German</div>
                <div class="languageSlideWidth colorBase1">Chinese</div>
                <div class="languageSlideWidth colorBase1">Japanese</div>
                <div class="languageSlideWidth colorBase1">Arabic</div>
            </div>
        </div>

    </section>

    <section id="section_4Media">

        <div class="section_4">

            <div class="languages9 w600">
                9 Languages - <span class="borderRed">Unlimited Possiblilities</span>
            </div>

            <div class="fontRecoleta divCarouselLanguages centerCarouselMedia slider">
                <div class="languageSlideWidth colorBase1">Spanish</div>
                <div class="languageSlideWidth colorBase1">French </div>
                <div class="languageSlideWidth colorBase1">Italian</div>
                <div class="languageSlideWidth colorBase1">Portuguese</div>
                <div class="languageSlideWidth colorBase1">Russian</div>
                <div class="languageSlideWidth colorBase1">German</div>
                <div class="languageSlideWidth colorBase1">Chinese</div>
                <div class="languageSlideWidth colorBase1">Japanese</div>
                <div class="languageSlideWidth colorBase1">Arabic</div>
            </div>
        </div>

    </section>

    <section id="section_5">

        <div class="section_5">

            <div class="fontRecoleta universitiesCarousel slider">
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Arizona-State-University.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Berkley-City-College.png')}}"> </div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Georgia-Tech.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/LSU.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Marquette-University.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Miami-Dade-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Moorpark-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/NC-State.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/New-Paltz.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Rutgers.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Smith-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Stony-Brook.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Texas-Tech.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Arizona.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-California-Santa-Barbara.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Cincinnati.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Florida.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Virginia.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Univiersity-of-Auburn.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Valdosta-State.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/William-and-Mary.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Wofford-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Yale.png')}}"></div>

            </div>

        </div>

    </section>

    <section id="section_5Media">

        <div class="section_5">

            <div class="fontRecoleta universitiesCarouselMedia slider">
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Arizona-State-University.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Berkley-City-College.png')}}"> </div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Georgia-Tech.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/LSU.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Marquette-University.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Miami-Dade-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Moorpark-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/NC-State.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/New-Paltz.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Rutgers.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Smith-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Stony-Brook.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Texas-Tech.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Arizona.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-California-Santa-Barbara.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Cincinnati.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Florida.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/University-of-Virginia.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Univiersity-of-Auburn.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Valdosta-State.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/William-and-Mary.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Wofford-College.png')}}"></div>
                <div class=" "><img src="{{asset('assets/img/web/school_logos/Yale.png')}}"></div>

            </div>

        </div>

    </section>


    <section id="section_9" class="paddingSection">

        <div class="section_9">

            <div class="row margin-top40">

                <div class="col-md-6">

                    <div class="text-54 colorBase2 fontRecoleta line_height1">
                        It's not an easy time
                        <br>to be a language
                        <br>instructor.
                    </div>

                    <div class="margin-top40">
                        <a href="{{url('how-it-works/instructors')}}" class="colorBase1 borderBottomText padding-bottom5" title="How it works for instructors"><strong>How it works</strong><i class="fas fa-chevron-right colorBase2 padding-left10 text-30 padding-top10"></i></a>
                    </div>

                    <div class="margin-top40">
                        <a href="{{route('coaches')}}" class="colorBase1 borderBottomText padding-bottom5" title="Our coaches"><strong>Learn about our coaches</strong><i class="fas fa-chevron-right colorBase2 padding-left10 text-30 padding-top10"></i></a>
                    </div>

                </div>

                <div class="col-md-6 colorBase1 text-21 line_height marginTopMedia">

                    <p>
                        Language departments are under pressure to attract and retain students – yet it can be hard to get students to see the relevance of language learning.
                    </p>

                    <p>
                        You have a huge heart and do everything you can to fire students up!
                    </p>

                    <p>
                        <strong>Do you notice students walking out of the classroom with low confidence and struggling to have basic conversations because they’re too nervous about making mistakes?</strong>
                    </p>

                    <p>
                        Thanks to your class, they have the skills. Now, they just need more practice!
                    </p>

                    <p>
                        <strong>Partner with LinguaMeeting! Your students will surprise you and themselves.</strong>
                    </p>

                </div>

            </div>

        </div>

    </section>

    <section id="section_6">

        <div class="paddingSection section_6">

            <div class="row divTextAnxiety">

                <div class="col-md-6 textAnxiety">
                    <div class="fontRecoleta">
                        Reduce student anxiety <span class="colorBase2">so practice feels like chatting with a friend.</span>
                    </div>


                    <a href="{{url('how-it-works/instructors')}}" title="How it works for instructors">
                    <div class="btnBasicRed textBtnLearnMore margin-top40 w600">

                        Learn More
                    </div>
                    </a>
                </div>



                <div class="col-md-6 text_center">

                    <div class="position_relative marginTopMedia">
                        <img src="{{asset('assets/img/web/mariaPazYale.png')}}" alt="María de la Paz García">

                        <div class="divAbsLogoPlay cursor_pointer">
                            <a href="{{asset('assets/video/studentAnxiety.mp4')}}" target="_blank" title="Reduce Student Anxiety">
                                <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>
                    </div>

                    <div class="margin-top40 w500">
                        <p class="text-32">
                            María de la Paz García, Ph.D.
                        </p>
                    </div>

                    <div class="margin-top20">
                        <p>
                            Yale University
                            <br>
                            <span class="colorBase2">
                                <strong>Senior Lector of Spanish</strong>
                            </span>
                        </p>

                    </div>

                </div>

            </div>

            <div class="divCircleLeft">

                <div>
                    <img class="imgCircleLeft" src="{{asset('assets/img/web/circleLeft.png')}}" alt="circle Left">
                </div>

            </div>


        </div>

    </section>

    <section id="section_7">

        <div class="section_7">

            <div class="row margin-top40">

                <div class="col-md-12 text_center">

                    <div class="testimonialsCarouselDiv">
                        <div class="testimonialsCarousel slider">
                        <div class="languageSlideWidth colorBase1">
                            <div class="colorWhite">
                                <span><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                            </div>

                            <div class="colorBase1 w500 text-28 margin-top10">
                                My coach Laura was amazing! She was so understanding, kind, and helpful!
                            </div>

                            <div class="colorBase1 w500 text-16 margin-top20">
                                - JAIDEN BLAKE D.
                            </div>
                        </div>
                        <div class="languageSlideWidth colorBase1">
                            <div class="colorWhite">
                                <span><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                            </div>

                            <div class="colorBase1 w500 text-28 margin-top10">
                                My language coach is so friendly, supportive, smart, and cheerful. I do not feel intimidated at all. My confidence has grown.
                            </div>

                            <div class="colorBase1 w500 text-16 margin-top20">
                                - CAITLIN ALEXANDER
                            </div>
                        </div>
                        <div class="languageSlideWidth colorBase1">
                            <div class="colorWhite">
                                <span><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                                <span class="margin_left10"><i class="fas fa-star"></i></span>
                            </div>

                            <div class="colorBase1 w500 text-28 margin-top10">
                                Linguameeting has been a great tool for me to learn, speak, and understand Spanish better.
                            </div>

                            <div class="colorBase1 w500 text-16 margin-top20">
                                - MARY PAHIDES
                            </div>
                        </div>

                    </div>

                    </div>


                </div>

            </div>


            <div class="row">

                <div class="col-md-12 text_center colorWhite text-23">

                    <div class="btnBasicWhiteLongGreen w600 margin_auto">
                        <a href="{{url('testimonials/students')}}" class="colorBase2" title="Students Testimonials">

                            View Testimonials

                        </a>
                    </div>

                </div>

            </div>




        </div>


    </section>

    <section id="section_8">

        <div class="section_8">

            <div class="divCrystal">

                <div>
                    <img class="imgCrystal" src="{{asset('assets/img/web/Case-Study-Crystal.png')}}" alt="Crystal Marull">
                </div>

            </div>

            <div class="row position_relative">
                <div class="col-md-6">

                    <div id="watchVideoCrystal" class="whatVideoCrystalNot">


                        <div class="cursor_pointer imgAbsPlay whatVideoCrystalNot">
                            <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM3WbQgpgh09gPZ1mHbflknn" target="_blank" title="Crystal Marull Story">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo" >
                            </a>
                        </div>

                    </div>

                    <div id="watchVideoCrystalMedia">

                        <div class="divCrystalMedia">

                            <div>
                                <img class="imgCrystal" src="{{asset('assets/img/web/Case-Study-Crystal.png')}}" alt="Crystal Marull">
                            </div>

                            <div class="cursor_pointer imgAbsPlay playCrystalMedia">
                                <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM3WbQgpgh09gPZ1mHbflknn" target="_blank" title="Crystal Marull Story">
                                    <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo" >
                                </a>
                            </div>

                        </div>




                    </div>


                </div>

                <div class="col-md-6 text_center">

                    <div class="text-38 fontRecoleta colorBase1 position_relative zIndex100 marginTopMedia">
                        Crystal Marull, Ph.D.
                    </div>

                    <div class="colorBase1 w600 margin-top20 position_relative zIndex100">
                        University of Florida Online

                    </div>
                    <div class="colorBase2  position_relative zIndex100">
                        <strong>Online Spanish Program Coordinator</strong>
                    </div>

                    <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_auto  position_relative zIndex100">
                        <a href="{{url('case-study/crystal')}}" class="colorBase4" title="Crystal Case Study">


                            View Case Study

                        </a>
                    </div>
                    <div class="colorBase1 fontRecoleta margin-top40 w500  position_relative zIndex100">
                        Growing the UF Online Spanish Program
                    </div>

                </div>
            </div>


        </div>



    </section>



    <section id="section_10" class="">

        <div class="section_10" title="Instructor background teaching">

            <div class="row">

                <div class="col-md-4">

                    <div class="text_center colorWhite marginTextWhatSay line_height">

                        <div>
                            WHAT OUR
                        </div>

                        <div class="fontRecoleta text-54">
                            Instructors
                        </div>

                        <div>
                            ARE SAYING
                        </div>

                    </div>

                </div>

                <div class="col-md-8 marginTopTestCarousel">

                    <div class="testimonialsInstCarousel slider ">
                        <div class="instSlideWidth colorBase1">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="boxTestInst">

                                        <div class="colorBase2 fontRecoleta text-28">
                                            “Motivation for students”
                                        </div>

                                        <div class="separatorDivHome margin-top10">

                                        </div>

                                        <div class="colorBase1 margin-top10 line_height w600 textNormalMedia">
                                            There's lots of research on this - frequent pleasant interactions with native speakers can create that internal motivation for students to want to try more. That’s the biggest benefit.
                                        </div>

                                        <div class="text_center colorBase1 margin-top40 w600 textNormalMedia">
                                            Jill Pelletieri
                                        </div>

                                        <div class="text_center colorBase2 textNormalMedia">
                                            Santa Clara University
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="boxTestInst">

                                        <div class="colorBase2 fontRecoleta text-28">
                                            “Patience and Friendliness”
                                        </div>

                                        <div class="separatorDivHome margin-top10">

                                        </div>

                                        <div class="colorBase1 margin-top10 line_height w600 textNormalMedia">
                                            Our students enjoy the sessions enormously and they rave about the coaches' patience and friendliness.
                                        </div>

                                        <div class="text_center colorBase1 margin-top40 w600 textNormalMedia">
                                            Prof. Helga Winkler
                                        </div>

                                        <div class="text_center colorBase2 textNormalMedia">
                                            Chair of World Languages at Moorpark College
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="instSlideWidth colorBase1">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="boxTestInst">

                                        <div class="colorBase2 fontRecoleta text-28">
                                            “Students love LinguaMeeting”
                                        </div>

                                        <div class="separatorDivHome margin-top10">

                                        </div>

                                        <div class="colorBase1 margin-top10 line_height w600 textNormalMedia">
                                            Students love LinguaMeeting.... at the beginning they really struggle and don't want to do it. By the end they always tell me how useful it was.
                                        </div>

                                        <div class="text_center colorBase1 margin-top40 w600 textNormalMedia">
                                            Luisa Baez
                                        </div>

                                        <div class="text_center colorBase2 textNormalMedia">
                                            University of Southern Mississippi
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="boxTestInst">

                                        <div class="colorBase2 fontRecoleta text-28">
                                            “It's just so cool ”
                                        </div>

                                        <div class="separatorDivHome margin-top10">

                                        </div>

                                        <div class="colorBase1 margin-top10 line_height w600 textNormalMedia">
                                            It was awesome to incorporate what they talked about and learned with their coaches into the class. They were able to tell me their coach's name, where they are from and share an additional detail about them. It's just so cool - next level!
                                        </div>

                                        <div class="text_center colorBase1 margin-top40 w600 textNormalMedia">
                                            Kate Brooke
                                        </div>

                                        <div class="text_center colorBase2 textNormalMedia">
                                            Texas Tech Univeristy
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>


    </section>

    <section id="section_11" class="paddingSection">

        <div class="section_11">

            <div class="unionCircles">
                <img src="{{asset('assets/img/web/unionCircles.png')}}" alt="Image union circles">

            </div>

            <div class="row margin-top40">

                <div class="col-md-6 ">

                    <div class="colorBase2 text-54 padding20 margin-top40">
                       We provide
                       <br>speaking practice <br>
                       that will make your
                       <br>students <span class="colorBase1">more
                           <br>engaged, confident,</span>
                       <br>and <span class="colorBase1">motivated.</span>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="colorBase2 text-21 listspeakingpractice padding20">
                        <ul class="ulListNew colorBase1 w500">
                            <li class="padding-top40">
                                Coaches who cheer students on
                            </li>

                            <li class="padding-top40">
                                Relationship-based learning
                            </li>

                            <li class="padding-top40">
                                A variety of session lengths and formats for all levels
                            </li>

                            <li class="padding-top40">
                                Coach-provided feedback plus recordings of every session
                            </li>

                            <li class="padding-top40">
                                <a href="{{route('pricing')}}" title="LinguaMeeting pricing"><span class="colorBase1 borderBottomText padding-bottom5"><strong>Affordable Pricing</strong></span><i class="fas fa-chevron-right colorBase2 padding-left10"></i></a>
                            </li>
                        </ul>
                    </div>


                </div>

            </div>

        </div>

    </section>


    <section id="section_12">

        <div class="section_12">

            <img src="{{asset('assets/img/web/ourStatsImage.png')}}" alt="LinguaMeeting Stats image">

        </div>


    </section>

    <section id="section_13" class="paddingSection">

        <div class="section_13">

            <div class="row marginCulture">

                <div class="col-md-6 text_centerMedia">

                    <div class="colorBase2 padding-left20 paddinConnectCultures w600">
                       CONNECT WITH CULTURES
                    </div>

                    <div class="colorBase1 text-54 fontRecoleta padding20 line_height1">
                       A study-abroad
                       <br>like experience
                       <br>for a fraction of
                       <br>the price.
                    </div>


                    <div class="padding20">
                        <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_autoMedia">
                            <a href="{{route('pricing')}}" class="colorBase4" title="LinguaMeeting pricing">

                                View Pricing

                            </a>
                        </div>
                    </div>


                </div>

                <div class="col-md-6">

                    <div class="colorBase2 liststudyabroad padding20">

                        <div class="colorBase2 padding20 margin-top40 w600">
                            THIS PRICING INCLUDES:
                        </div>

                        <ul class="padding20 ulListNew w600 colorBase1">
                            <li class="margin-top20">
                                Instructor portal access
                            </li>

                            <li class="margin-top40">
                                Complete course consultation
                            </li>

                            <li class="margin-top40">
                                Session recording and archiving
                            </li>

                            <li class="margin-top40">
                                Coach feedback for every session
                            </li>

                            <li class="margin-top40">
                                Same-day scheduling
                            </li>

                            <li class="margin-top40">
                                A ready-to-export grading report
                            </li>
                        </ul>
                    </div>


                </div>

            </div>


        </div>

    </section>

    <section id="section_14" title="Coaches Inca Monument">

        <div class="section_14">

            <div class="row">

                <div class="col-md-12 text_center colorWhite experiencesTrasncend w500 line_height1">

                    <div>
                        TRANSCEND THE TEXTBOOK

                    </div>

                    <div class="text-54 margin-top40 fontRecoleta">
                        <span class="colorBase1">Live</span> cultural presentations
                        <br>from all over the world.
                        <br><span class="colorBase1">All year long.</span>
                    </div>

                    <a href="{{route('experiences')}}" title="LinguaMeeting Experiences">
                    <div class="btnBasicRed textBtnLearnMore padding-top40 margin_auto margin-top40 w600">
                        Experiences
                    </div>
                    </a>

                </div>


            </div>

            <div class="coachesInca">

                <img class="" src="{{asset('assets/img/web/coachesInca.png')}}" alt="Coaches Inca">

            </div>

            <div class="coachesIncaText">

                <img class="" src="{{asset('assets/img/web/coachesIncaText.png')}}" alt="Coaches Inca Text">

            </div>


        </div>


    </section>


    <section id="section_15" class="">

        <div class="section_15">


             <div class="fontRecoleta colorBase1 text-54 text_center margin-top40">
                Upcoming Experiences
            </div>

            <div class="" id="experiencesCarouselHome">

                <div class="experiencesHomeCarousel slider ">


                    @foreach ($experiences as $exp)
                    <div class="boxExpCarousel colorBase1">

                        <div class="expRoundCorner">

                            @foreach ($exp->file as $file)
                            @if ($file->order==2)
                            <img src="{{$file->filename}}" class="" alt="{{$exp->title}}"/>
                            @endif
                            @endforeach
                        </div>

                        <div class="text-18 w500 margin-top20 padding-left10 padding-right10 colorBase1">
                            <a href="experiencesSearch/{{$exp->id}}" class="colorBase1" title="{{$exp->title}}">
                                <div class="">
                                    {{$exp->title}}
                                </div>
                            </a>
                        </div>

                        <div class="text-16 colorBase2 padding10">
                            <strong>{{toFormattedDayDateString($exp->start, $experienceTimezone)}} </strong>

                        </div>

                        <div class="text-16 w500 padding-left10 padding-right10">
                         {{toTime24h($exp->start, $experienceTimezone)}}   to {{toTime24h($exp->end, $experienceTimezone)}} (EST)

                        </div>

                        <div class="positionBottom">
                            <a href="searchExperience/{{$exp->id}}" class="float_right" title="{{$exp->title}}">
                                <div class="btnBasicTransparent margin-top40 w500 textBtnLearnMore margin_auto">

                                    Learn More
                                </div>
                            </a>
                        </div>


                    </div>

                    @endforeach

                </div>

            </div>


            <div class="" id="experiencesCarouselHomeMedia">

                <div class="experiencesHomeCarouselMedia slider ">

                    @foreach ($experiences as $exp)
                    <div class="boxExpCarousel colorBase1">

                        <div class="expRoundCorner">

                            <img src="{{$exp->banner2}}" class="" alt="{{$exp->title}}"/>


                        </div>

                        <div class="text-18 w500 margin-top20 padding-left10 padding-right10 colorBase1">
                            <a href="experiencesSearch/{{$exp->id}}" class="colorBase1" title="{{$exp->title}}">
                                <div class="">
                                    {{$exp->title}}
                                </div>
                            </a>
                        </div>

                        <div class="text-16 colorBase2 padding10">
                            <strong>{{toFormattedDayDateString($exp->start, $experienceTimezone)}}</strong>

                        </div>

                        <div class="text-16 w500 padding-left10 padding-right10">
                            {{toTime24h($exp->start, $experienceTimezone)}} to {{toTime24h($exp->end, $experienceTimezone)}} (EST)

                        </div>

                        <div class="positionBottom">
                            <a href="searchExperience/{{$exp->id}}" class="float_right" title="{{$exp->title}}">
                                <div class="btnBasicTransparent margin-top40 w500 textBtnLearnMore margin_auto">

                                    Learn More
                                </div>
                            </a>
                        </div>


                    </div>

                    @endforeach

                </div>

            </div>



        </div>

    </section>

</main>


@include('common.web.footer')

</body>
</html>

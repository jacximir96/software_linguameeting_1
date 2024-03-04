<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>
    
    <section id="section1_hi">
        
         <div class="paddingSection">
            
            <div class="row divTextAnxiety" id="section1HIW">
                
                <div class="col-md-6 colorBase1 text-21 padding-top40 line_height">
                    <div class="text_right connectHI w500">
                        Connect your students
                        <br>to language coaches by
                        <br>completing a brief form.

                        <div class="btnBasicTransparent textBtnLearnMore margin-top40 btnScheduleHI w600">
                            <a href="{{route('contact')}}" class="colorBase4">

                                Schedule a Demo

                            </a>
                        </div>

                    </div>
 
                </div>
                
                
                
                <div class="col-md-6">
                    <div class="colorBase1 w500 text_right line_height">
                        SET YOUR COURSES UP FOR SUCCESS

                    </div>
                    
                     <div class="setCourses colorBase2 line_height1">
                        Let our language
                        <br>coaches<span class="colorBase1"> take work</span>
                        <br><span class="colorBase1">off your plate</span>

                    </div>

                </div>
                
            </div>
          
            <div id="section1HIWMedia">

                <div class="colorBase1 w500 line_height text_center">
                    SET YOUR COURSES UP FOR SUCCESS

                </div>

                <div class="setCourses colorBase2 line_height1 marginTopMedia">
                    Let our language
                    <br>coaches<span class="colorBase1"> take work</span>
                    <br><span class="colorBase1">off your plate</span>

                </div>


                <div class="colorBase1 text-21 padding-top40 line_height text_center">
                    <div class="w500">
                        Connect your students
                        <br>to language coaches by
                        <br>completing a brief
                        <br>coaching form.

                        
                    </div>

                </div>

                <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600 margin_auto text_center">
                    <a href="{{route('contact')}}" class="colorBase4">

                        Schedule a Demo

                    </a>
                </div>

            </div>
             
        </div>
        
    </section>
    
    <section id="section2_hi">
        
        <div class="section2_hi" id="CaseStudyCrystal">
            
            <div class="divCrystalHI">

                <div>
                    <img class="imgCrystalHI" src="{{asset('assets/img/web/Case-Study-Crystal.png')}}" alt="Crystal Marull">
                </div>

            </div>

            <div class="row position_relative">
                

                <div class="col-md-6">
                    <div id="watchVideoCrystal">

                        <div class="margin-top40 cursor_pointer imgAbsPlay">
                            <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM3WbQgpgh09gPZ1mHbflknn" target="_blank" title="Case Study Crystal Marull">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 text_center">
                    
                    <div class="">
                        <img src="{{asset('assets/img/web/meetText.png')}}" alt="Text Crystal">
                    </div>
                    
                    <div class="text-38 fontRecoleta colorBase1">
                        Crystal Marull, Ph.D.
                    </div>
                    
                    <div class="colorBase1 w500 margin-top20">
                        University of Florida Online

                    </div>
                    <div class="colorBase2 w500">
                        <strong>Spanish Program Coordinator</strong>
                    </div>

                    <div class="divLinkButton">
                        <a href="{{url('case-study/crystal')}}" title="Case Study Crystal">
                            <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_auto">

                                View Case Study
                            </div>
                        </a>
                    </div>
                    <div class="margin-top40 w400">
                        <img src="{{asset('assets/img/web/docsCaseStudy2.png')}}" alt="Coach Experience">
                    </div>
                    
                    <div class="linguaStoryArrowLeft">

                        <i class="fas fa-chevron-left colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('Kate');"></i>

                    </div>
                    
                    <div class="linguaStoryArrowRight">

                        <i class="fas fa-chevron-right colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('Kate');"></i>

                    </div>
                    
                </div>
            </div>

            
        </div>
        
        <div class="section2_hi" id="CaseStudyKate">
            
            <div class="divKateHI">

                <div>
                    <img class="imgKateHI" src="{{asset('assets/img/web/case-study-kate.png')}}" alt="Kate Brooke">
                </div>

            </div>

            <div class="row position_relative">
                <div class="col-md-6">

                    <div id="watchVideoCrystal">

                        <div class="margin-top40 cursor_pointer imgAbsPlay">
                            <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM2T5gCjQkEQ5rrZXcyuN7MB" target="_blank" title="Case Study Kate Brooke">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>

                    </div>


                </div>

                <div class="col-md-6 text_center">
                    
                    <div class="">
                        <img src="{{asset('assets/img/web/meetText.png')}}" alt="Case Study Kate">
                    </div>
                    
                    <div class="text-38 fontRecoleta colorBase1  position_relative zIndex">
                        Prof. Kate Brooke
                    </div>
                    
                    <div class="colorBase1 w500 margin-top20  position_relative zIndex">
                        Texas Tech University

                    </div>
                    <div class="colorBase2 w500  position_relative zIndex">
                        <strong>Director of Spanish Foundations Program</strong>
                    </div>

                    <div class="divLinkButton">
                    <a href="{{url('case-study/kate')}}" title="Case Study Kate">
                        <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_auto position_relative zIndex">

                            View Case Study
                        </div>
                    </a>
                    </div>
                    <div class="margin-top40 ">
                        <img src="{{asset('assets/img/web/docsCaseStudy.png')}}" alt="Case Study Doc">
                    </div>
                    
                    <div class="linguaStoryArrowLeft">

                        <i class="fas fa-chevron-left colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('Crystal');"></i>

                    </div>
                    
                    <div class="linguaStoryArrowRight">

                        <i class="fas fa-chevron-right colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('Crystal');"></i>

                    </div>

                </div>
            </div>

            
        </div>
        
        <div class="section2_hi" id="CaseStudyKateMedia">
            
            <div class="position_relative">

                <div class="text_center">
                    <img class="imgKateHI" src="{{asset('assets/img/web/case-study-kate.png')}}" alt="Kate Brooke">
                </div>
                
                <div id="watchVideoCrystal">

                        <div class="margin-top40 cursor_pointer imgAbsPlay">
                            <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM2T5gCjQkEQ5rrZXcyuN7MB" target="_blank" title="Case Study Kate">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>

                    </div>

            </div>

            <div class="row position_relative">

                <div class="col-md-12 text_center">
                    
                    <div class="">
                        <img src="{{asset('assets/img/web/meetText.png')}}" alt="Case Study Kate">
                    </div>
                    
                    <div class="text-38 fontRecoleta colorBase1  position_relative zIndex">
                        Prof. Kate Brooke
                    </div>
                    
                    <div class="colorBase1 w500 margin-top20  position_relative zIndex">
                        Texas Tech University

                    </div>
                    <div class="colorBase2 w500  position_relative zIndex">
                        <strong>Director of Spanish Foundations Program</strong>
                    </div>

                    <div class="divLinkButton">
                    <a href="{{url('case-study/kate')}}" title="Case Study Kate">
                        <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_auto position_relative zIndex">

                            View Case Study
                        </div>
                    </a>
                    </div>
                    <div class="margin-top40 ">
                        <img src="{{asset('assets/img/web/docsCaseStudy.png')}}" alt="Case Study Kate">
                    </div>
                    
                    <div class="linguaStoryArrowLeft">

                        <i class="fas fa-chevron-left colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('CrystalMedia');"></i>

                    </div>
                    
                    <div class="linguaStoryArrowRight">

                        <i class="fas fa-chevron-right colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('CrystalMedia');"></i>

                    </div>

                </div>
            </div>

            
        </div>
        
        <div class="section2_hi" id="CaseStudyCrystalMedia">
            
            <div class="position_relative">

                <div class="text_center">
                    <img class="imgCrystalHI" src="{{asset('assets/img/web/Case-Study-Crystal.png')}}" alt="Crystal Marull">
                </div>
                
                <div id="watchVideoCrystal">

                        <div class="margin-top40 cursor_pointer imgAbsPlay">
                            <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM3WbQgpgh09gPZ1mHbflknn" target="_blank" title="Case Study Crystal Marull">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>

                    </div>

            </div>

            <div class="row position_relative">

                <div class="col-md-12 text_center">
                    
                    <div class="">
                        <img src="{{asset('assets/img/web/meetText.png')}}" alt="Case Study Crystal">
                    </div>
                    
                    <div class="text-38 fontRecoleta colorBase1">
                        Crystal Marull, Ph.D.
                    </div>
                    
                    <div class="colorBase1 w500 margin-top20">
                        University of Florida Online

                    </div>
                    <div class="colorBase2 w500">
                        <strong>Online Spanish Program Coordinator</strong>
                    </div>

                    <div class="divLinkButton">
                        <a href="{{url('case-study/crystal')}}" title="Case Study Crystal">
                            <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_auto">

                                View Case Study
                            </div>
                        </a>
                    </div>
                    <div class="margin-top40 w400">
                        <img src="{{asset('assets/img/web/docsCaseStudy2.png')}}" alt="Case Study Doc">
                    </div>
                    
                    <div class="linguaStoryArrowLeft">

                        <i class="fas fa-chevron-left colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('KateMedia');"></i>

                    </div>
                    
                    <div class="linguaStoryArrowRight">

                        <i class="fas fa-chevron-right colorBase1 text-28 cursor_pointer" onclick="changeCaseStudyHIW('KateMedia');"></i>

                    </div>

                </div>
            </div>

            
        </div>
    
    
    </section>
    
    <section id="section3_hi">
        
        <div class="section3_hi paddingSection">
            
            <div class="row margin-top40 ">
                
                <div class="col-md-6">
                    
                    <div class="colorBase2 loveStudentsDiv marginTopMedia">
                        You'd love for your students to get all <span class="colorBase1">the benefits of regular speaking practice,</span> including:
                    </div>
                    
                </div>
                
                <div class="col-md-6 colorBase1">
                    
                    <div class="text-21 listspeakingpractice padding20">
                        <ul class="ulListHIW">
                            <li class="margin-top40">
                                Authentic and ongoing connection with native speakers
                            </li>
                            
                            <li class="margin-top40">
                                A big boost in confidence and motivation
                            </li>
                            
                            <li class="margin-top40">
                                Guidance on how to use language in everyday contexts
                            </li>
                            
                            <li class="margin-top40">
                                The realization that they can do this and more!
                            </li>

                        </ul>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </section>
    
     <section class="backgroundColorBase3 position_relative zIndex100">
        
        
        <div class="paddingSection backgroundColor1">
            
            <div class="boxVoices">
                
                <div class="row colorBase1">
                    
                    <div class="col-xl-3 col-lg-6 col-md-6 text_center">
                        
                        <div class="margin-top10">
                            <img src="{{asset('assets/img/web/expIcon02Grey.png')}}" alt="LinguaMeeting experience" class="heightIconLogoGrey">
                        </div>
                        
                        <div class="fontRecoleta text-65">
                            Voices
                        </div>
                        
                        <div class="text-18">
                            INSTRUCTOR STORIES
                        </div>
                        
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="position_relative">

                            <div class="text_center margin-top10">

                                <img class="imgVoiceHI" src="{{asset('assets/img/web/voice-crystal.png')}}" alt="instructor voices 1">

                            </div>

                            <div class="divgGuyLogoPlay cursor_pointer">
                                <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM3WbQgpgh09gPZ1mHbflknn" target="_blank" title="Instructor voices 1">
                                    <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Outlined.png')}}" alt="Play Logo">
                                </a>

                            </div>


                        </div>

                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="position_relative">

                            <div class="text_center margin-top10">

                                <img class="imgVoiceHI" src="{{asset('assets/img/web/voice-kate.png')}}" alt="instructor voices 2">

                            </div>

                            <div class="divgGuyLogoPlay cursor_pointer">
                                <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM2T5gCjQkEQ5rrZXcyuN7MB" target="_blank" title="instructor voices 2">
                                    <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Outlined.png')}}" alt="Play Logo" >
                                </a>
                            </div>


                        </div>

                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6">

                        <div class="position_relative">

                            <div class="text_center margin-top10">

                                <img class="imgVoiceHI" src="{{asset('assets/img/web/voice-jill.png')}}" alt="instructor voices 3">

                            </div>

                            <div class="divgGuyLogoPlay cursor_pointer">
                                <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM1JEWZcy5sxgdE6V6y-uFOk" target="_blank" title="instructor voices 3">
                                    <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Outlined.png')}}" alt="Play Logo" >
                                </a>
                            </div>


                        </div>

                    </div>


                </div>


            </div>
            
            
        </div>
        
    </section>
    
       
    <section id="section4_hi">
        
        <div class="section_7">
            
            <div class="row">
                
                <div class="col-md-12 text_center">

                    <div class="testimonialsCarouselDiv line_height">
                        <div class="testimonialsCarousel slider">
                        <div class="languageSlideWidth colorBase1">

                            <div class="colorWhite w400 text-28 ">
                                There's lots of research on this - frequent pleasant interactions with native speakers can create that internal motivation for students to want to try more. That’s the biggest benefit.
                                        
                            </div>

                            <div class="colorBase1 w600 text-16 margin-top20">
                                Jill Pelletieri
                            </div>
                            <div class="colorBase1 w500 text-16">
                                Santa Clara University
                            </div>
                        </div>
                        <div class="languageSlideWidth colorBase1">
                            <div class="colorWhite w400 text-28">
                               Our students enjoy the sessions enormously and they rave about the coaches' patience and friendliness.
                            </div>

                            <div class="colorBase1 w600 text-16 margin-top20">
                                Prof. Helga Winkler
                            </div>
                            <div class="colorBase1 w500 text-16">
                                Chair of World Languages at Moorpark College
                            </div>
                        </div>
                        <div class="languageSlideWidth colorBase1">

                            <div class="colorWhite w400 text-28">
                                Students love LinguaMeeting.... at the beginning they really struggle and don't want to do it. By the end they always tell me how useful it was.
                                        
                            </div>

                            <div class="colorBase1 w600 text-16 margin-top20">
                                <strong>Luisa Baez</strong>
                            </div>
                            <div class="colorBase1 w500 text-16">
                                University of Southern Mississippi
                            </div>
                        </div>
                        
                    </div>
                        
                    </div>
                    

                </div>

            </div>
            
            
            <div class="row">
                
                <div class="col-md-12 text_center colorWhite text-23 margin-bottom40">

                    <div class="btnBasicWhiteLongGreen w600 margin_auto">
                        <a href="{{url('testimonials/students')}}" class="colorBase2">

                            View Testimonials

                        </a>
                    </div>
                    
                </div>
                
            </div>
            
            
            
            
        </div>
        
    </section>
        
   
    <section >
        
        <div class="margin-top60">

            

            <div class="row boxSteps1">                            
                <div class="col-md-12 w500 text_center">
                    <div>
                        <div class="margin-top20">STEP 1:</div>
                        <div class="fontRecoleta text-32 margin-top10 margin-bottom10">
                            Set up Your Account
                            
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

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/step1-hiw.png')}}" alt="step 1 how it worsk">
                    </div>

                </div>

            </div>

            
            <div class="row text-21 boxSteps2Color">                            
                <div class="col-md-12 w500 text_center">
                    <div>
                        <div class="margin-top20">STEP 2:</div>
                        <div class="fontRecoleta text-32 margin-top10 margin-bottom10">
                           Build Your Course
                            
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

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/step2-hiw.png')}}" alt="step 2 how it worsk">
                    </div>

                </div>

            </div>
            
            
            
            <div class="row text-21 boxSteps3White">                            
                <div class="col-md-12 w500 text_center">
                    <div>
                        <div class="margin-top20">STEP 3:</div>
                        <div class="fontRecoleta text-32 margin-top10 margin-bottom10">
                           Share Instructions with Students
                            
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

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/step3-hiw.png')}}" alt="step 3 how it worsk">
                    </div>

                </div>

            </div>
            
            
            
            
            
        </div>
        
        
    </section>
    
    
    <section id="section6_hi">
        <div class="section6_hi paddingSection">
            
            <div class="text_center">
                <img src="{{asset('assets/img/web/coachesHI.png')}}" alt="Coaches">
            </div>

            <div class="watchVideoMaribel">

                <div class="margin-top40 cursor_pointer imgAbsPlayMaribel">
                    <a href="{{route('coaches')}}#sectionCoachesMap" title="Coaches map">
                        <img class="imgAbsPlayMaribel" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                    </a>
                </div>

            </div>

            

        </div>
    </section>
    
    
    <section id="section7_hi">
        
        <div class="section6_hi paddingSection">
            
            <div class="row">
                
                <div class="col-md-6 padding20">
                    
                    <div class="colorBase1 w500 ">
                        CONNECT WITH THE BEST

                    </div>
                    
                    <div class="text-54 colorBase1 fontRecoleta margin-top20">
                        Your students 
                        <br>will <span class="colorBase2">love</span> our 
                        <br>language 
                        <br>coaches
                    </div>
                    
                    <div class="colorBase1 text-21 w500 margin-top20 line_height">
                        Upon registration, your students will be able to read through the profiles of various coaches and choose the one they’d like to work with.
                    </div>

                    <a href="{{route('coaches')}}">
                        <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600">

                            Meet our coaches
                        </div>
                    </a>

                </div>
                
                <div class="col-md-6 padding20">
                    
                    <div class="colorBase1 text-21 liststudyabroad">
                        
                        <div class="colorBase2 padding20 w500">
                            OUR LANGUAGE COACHES WILL
                        </div>

                        <ul class="padding20 ulListNew line_height">
                            <li class="margin-top40">
                                <strong>Put your students at ease</strong> and cheer them on
                            </li>
                            
                            <li class="margin-top40">
                                <strong>Prompt students struggling to articulate an idea</strong> - by using synonyms, cognates, and images when they get stuck (but not correcting or teaching)
                            </li>
                            
                            <li class="margin-top40">
                               <strong>Use a grading rubric</strong> so you can access feedback on every student session (and translate this into grades).
                            </li>
                            
                            <li class="margin-top40">
                                <strong>Follow the topics/assignments</strong> uploaded for each course
                            </li>
                            
                            <li class="margin-top40">
                                Help to <strong>reduce foreign language anxiety</strong>
                            </li>

                        </ul>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
        
    </section>
    
    <section id="section8_hi">
        
        <div class="paddingSection">
            
            <div class="text_center colorBase1 w600">
                WE’VE GOT YOU COVERED
            </div>
            
            <div class="text-70 margin-top10 text_center colorBase2">
                Frequently Asked Questions 
            </div>
            
            <div>

                <div class="row margin-top40 text-21 boxFAQs">                            
                    <div class="col-md-8 colorBase1 line_height">                                
                        <strong>What is the price?</strong>                            
                    </div>                            
                    <div class="col-md-4">                                
                        <div class="float-right text-28">                                    
                            <i class="fas fa-chevron-down cursor_pointer colorBase2" data-toggle="collapse" href="#FAQ1" role="button" aria-expanded="false" aria-controls="FAQ1" data-fa-i2svg="">
                                
                            </i>                                
                        </div>                            
                    </div>                        
                </div>
                
                <div class="collapse line_height" id="FAQ1">  
                    
                    <div class="padding20 text-18 w500 colorBase1">
                        Price depends on the session type and duration. Price can be as low as $5.80 per session.
                    </div>
                    
                </div>
                
                <div class="row margin-top40 text-21 boxFAQs">                            
                    <div class="col-md-8 colorBase1 line_height">                                
                        <strong>How do group sessions work?</strong>                            
                    </div>                            
                    <div class="col-md-4 ">                                
                        <div class="float-right text-28">                                    
                            <i class="fas fa-chevron-down cursor_pointer colorBase2" data-toggle="collapse" href="#FAQ2" role="button" aria-expanded="false" aria-controls="FAQ2" data-fa-i2svg="">
                                
                            </i>                                
                        </div>                            
                    </div>                        
                </div>
                
                <div class="collapse line_height" id="FAQ2">  
                    
                    <div class="padding20 text-18 w500 colorBase1">
                        Group sessions are simple. Your students register,  and then they select sessions which other students in their class can join. No need for professors to organize students into groups, the algorithm does the work for you! With an average of 2 students per session, group sessions offer a great way for students to ease their way into language aquisition as they can rely on their classmates to help them through.
                    </div>
                    
                </div>
                
                <div class="row margin-top40 text-21 boxFAQs">                            
                    <div class="col-md-8 colorBase1 line_height">                                
                        <strong>For students in group sessions, will less social students be isolated?</strong>                            
                    </div>                            
                    <div class="col-md-4">                                
                        <div class="float-right text-28">                                    
                            <i class="fas fa-chevron-down cursor_pointer colorBase2" data-toggle="collapse" href="#FAQ3" role="button" aria-expanded="false" aria-controls="FAQ3" data-fa-i2svg="">
                                
                            </i>                                
                        </div>                            
                    </div>                        
                </div>
                
                <div class="collapse line_height" id="FAQ3">  
                    
                    <div class="padding20 text-18 w500 colorBase1">
                        To the contrary, we have found that group sessions are great for less social students! Because students cannot see the names of other students in the session they are joining, and the fact that any student in the class can join any session with a seat available, less social students have more opportunities to meet and interact with their classmates. 
                    </div>
                    
                </div>
                
                <div class="row margin-top40 text-21 boxFAQs">                            
                    <div class="col-md-8 colorBase1 line_height">                                
                        <strong>How can students get started?</strong>                            
                    </div>                            
                    <div class="col-md-4">                                
                        <div class="float-right text-28">                                    
                            <i class="fas fa-chevron-down cursor_pointer colorBase2" data-toggle="collapse" href="#FAQ4" role="button" aria-expanded="false" aria-controls="FAQ4" data-fa-i2svg="">
                                
                            </i>                                
                        </div>                            
                    </div>                        
                </div>
                
                <div class="collapse line_height" id="FAQ4">  
                    
                    <div class="padding20 text-18 w500 colorBase1">
                        Once your course is created, we provide you with a pdf of instructions for students. In those instructions there is a link to your course. For students it is simple: They click the link, fill in their basic information, and start selecting sessions. 
                    </div>
                    
                </div>
                
                <div class="row margin-top40 text-21 boxFAQs">                            
                    <div class="col-md-8 colorBase1 line_height">                                
                        <strong>Are there recordings of the students' sessions?</strong>                            
                    </div>                            
                    <div class="col-md-4">                                
                        <div class="float-right text-28">                                    
                            <i class="fas fa-chevron-down cursor_pointer colorBase2" data-toggle="collapse" href="#FAQ5" role="button" aria-expanded="false" aria-controls="FAQ5" data-fa-i2svg="">
                                
                            </i>                                
                        </div>                            
                    </div>                        
                </div>

                
                <div class="collapse line_height" id="FAQ5">  
                    
                    <div class="padding20 text-18 w500 colorBase1">
                        Professors have access to video recordings of every session.
                    </div>
                    
                </div>
                
                <div class="row margin-top40 text-21 boxFAQs">                            
                    <div class="col-md-8 colorBase1 line_height">                                
                        <strong>What is your quality control procedure?</strong>                            
                    </div>                            
                    <div class="col-md-4">                                
                        <div class="float-right text-28">                                    
                            <i class="fas fa-chevron-down cursor_pointer colorBase2" data-toggle="collapse" href="#FAQ6" role="button" aria-expanded="false" aria-controls="FAQ6" data-fa-i2svg="">
                                
                            </i>                                
                        </div>                            
                    </div>                        
                </div>

                
                <div class="collapse line_height" id="FAQ6">  
                    
                    <div class="padding20 text-18 w500 colorBase1">
                        Our coaches are reviewed biweekly. Professors can not only see our quality control feedback for a given coach from their portal, but also leave their own quality control feedback. 
                    </div>
                    
                </div>
                
                
                <div class="margin-top40 text_center text-21">
                    
                    <div class="colorBase1 w600">
                        Have more questions? We have answers!
                    </div>
                    
                    <a href="{{route('support')}}">
                        <div class="btnBasicTransparent margin-top40 w600 textBtnLearnMore margin_auto">
                            Support Page
                        </div>
                    </a>
                    
                </div>
                        
            </div>
            
        </div>
        
    </section>
    
    
</main>

@include('common.web.footer')

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>
    
    <section id="section1_a">
        
        <div class="section1_a">
            
            <div class="">
                <div class="row text-32">

                    <div class="col-md-4 text_center">

                        <div class="colorBase1 ">
                            <span class='borderBottomText'>Our Story</span>
                        </div>
                    </div>

                    <div class="col-md-4 text_center">

                        <a href="#section5_a" class="colorBase2">
                            Team
                        </a>

                    </div>

                    <div class="col-md-4 text_center">

                        <a href="#section6_a" class="colorBase2">
                            Partners
                        </a>

                    </div>



                </div>
            </div>
            
        </div>
        
    </section>
    
    
    <section id="section2_a">
        
        <div class="paddingSection">
            
            <div class="colorBase1 text_center w600">
                THE LINGUA MEETING STORY
            </div>
            
            <div class="colorBase2 text_center text-70 fontRecoleta borderBottomText padding-bottom20 line_height1 margin-top10">
                An Idea Sparked by a <br>Changing World
            </div>

            <div class="linguaStory line_height">

                <div class="w600 colorBase1 margin-top40 text-21 ">
                    <p>
                        In the fall of 2005, I welcomed my University of New Orleans Spanish students on the first day of class—and then never saw them in person again.
                    </p>

                    <p class="margin-top40">
                        Hurricane Katrina hit the following Monday morning, flooding the campus and changing our lives forever...
                    </p>
                </div>

                <div class="w500 colorBase1 margin-top40 text-21 linguaStoryNext">
                    <p class="margin-top20">
                        Eventually, we started the process of moving our Spanish courses online and I found that the logistics of connecting students with native speakers on Skype were challenging to say the least.
                    </p>
                    <p class="margin-top20">
                        Despite the difficulties, I immediately saw how connecting students and coaches for authentic, low-anxiety conversations brought real magic to the language-learning process
                    </p>
                    <p class="margin-top20">
                        These days, improved technology has made these kinds of connections much easier and LinguaMeeting has grown to over 200 schools, with 100,000 students per year, more than 100 language coaches, and a global team.
                    </p>
                    <p class="margin-top20">

                        The need for speaking practice and cultural exchange continues to grow—and LinguaMeeting is proud to support it all with our network of wonderful coaches and user-friendly platform.
                    </p>
                </div>

            </div>
            <div class="margin-top60">
                <div class="row colorBase1">
                    
                    <div class="col-md-6 text_center">
                        <img src="{{asset('assets/img/web/elenastoryphoto.png')}}" alt="Elena Casillas">
                    </div>
                    
                    <div class="col-md-6 margin-top40">
                        
                        <p class="text-21 line_height">
                            <strong>Our relationship-based approach creates a trusted connection in which confidence, curiosity, and cultural competence can grow.
By guiding students from simple language practice to real-world conversations, we hope to inspire language learners to continue their journey!
</strong>
                        </p>
                        
                        <img src="{{asset('assets/img/web/letras_elena.png')}}" alt="Elena Casillas Firma">
                        
                        <p class="margin-top20 w600">
                            ELENA CASILLAS
                            <br>
                            Instructor of Spanish and Founder of LinguaMeeting
                        </p>

                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
        
    </section>
    
    
    <section id="section3_a" class="section3_a">
        
        <div class="paddingSection">
            
            <div class="row margin-top40">
                
                <div class="col-md-5 w500">
                    <div class="w500 colorBase1">
                        MEET
                    </div>
                    
                    <div class="w500 colorWhite text-54 fontRecoleta">
                        Will Rogich
                    </div>
                    <div class="w500 colorBase1 text-21 line_height">
                        Discover how Will fell in love with Spain, persued his passion for language and became <strong>a valuable member</strong> of the <strong>LinguaMeeting Team</strong>.
                    </div>
                    <div class="margin-top20" >
                        <a href="{{asset('assets/video/Will_story.mov')}}" class="btnBasicWith" target="_blank">
                            <div class="btnBasicTransparentWhite w600">
                                Watch Will's Story
                            </div>
                        </a>

                    </div>
                    
                </div>
                
                <div class="col-md-2">
                    
                    <div class="separatorVerticalWhite">
                        
                    </div>
                </div>
                
                <div class="col-md-5 w400">
                    
                    <div class="position_relative text_center marginTopMedia">
                        <img src="{{asset('assets/img/web/WillRogich.png')}}" alt=" Will Rogich">
                        
                        <div class="divAbsLogoPlay cursor_pointer">
                            <a href="{{asset('assets/video/Will_story.mov')}}" target="_blank" title="Will Rogich story">
                            <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo">
                            </a>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
            
        </div>
        
    </section>
    
    
    
    <section id="section4_a">
        
        <div class="section4_a paddingSection">
            
            <div class="row">
                <div class="col-md-2 img_vertical">
                    
                    <div class="colorBase4 w500" id="OurMissionLet">
                        <img src="{{asset('assets/img/web/our_mission_let.png')}}">
                    </div>
                    
                </div>
                
                <div class="col-md-2 clear_both">
                    
                    <div class="separatorVertical">
                        
                    </div>
                    
                </div>
                <div class="col-md-8 fontRecoleta text-72 colorBase1 line_height1">
                    <span class="colorBase2">We strive to give students</span>
                    <br>an unforgettable learning
                    <br>experience <span class="colorBase2">and</span> a lifelong
                    <br>passion for new languages 
                    <br>and cultures.
                </div>
            </div>
            
            <div class="margin-top60 text_cener text-32 colorBase2 text_center">
                
                More info on our coaches can be found in our <span class="w600 colorBase1 borderBottomText"><a href="{{route('coaches')}}" class="colorBase1">[FAQs]</a></span>
            </div>
            
        </div>
        
    </section>
    
    
    <section id="section5_a">

        <div class="paddingSection">

            <div class="row w600 text-23">

                <div class="col-6 colorBase1 text_right">
                    MEET THE TEAM
                </div>


                <div class=" borderLeftText col-6 colorBase2">
                    Who Makes It All Possible
                </div>
            </div>



            <div class="separatorHorizontal" id="separatorHorizontal">

            </div>


            <div class="row margin-top40">

                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Elena.png')}}" alt="Elena Casillas">
                    </div>

                    <a href="#section1_a" onclick="" class="colorBase1">
                        <div class="fontRecoleta text-25 text_center">
                            Elena Casillas
                        </div>
                    </a>
                    <div class="text-12 text_center w600">
                        FOUNDER
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Andrea.png')}}" alt="Andrea Calderon" onclick="modalText('Andrea');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Andrea');" class="colorBase1">

                            Andrea Calderon

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        OPERATIONS COORDINATOR
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Sandra.png')}}" alt="Sandra Campos" onclick="modalText('Sandra');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Sandra');" class="colorBase1">

                            Sandra Campos

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        DEVELOPER
                    </div>

                </div>


            </div>
            
            <div class="row margin-top20">

                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Maria.png')}}" alt="Maria J. Centeno" onclick="modalText('Maria');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Maria');" class="colorBase1">

                            Maria J. Centeno

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        EXPERIENCES COORDINATOR
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Maribel.png')}}" alt="Maribel Chuquichaico" onclick="modalText('Maribel');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Maribel');" class="colorBase1">

                            Maribel Chuquichaico

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        QUALITY MANAGER + COACH SUPPORT
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Carmen.png')}}" alt="Carmen Cidoncha" onclick="modalText('Carmen');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Carmen');" class="colorBase1">

                            Carmen Cidoncha

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        OPERATION MANAGER
                    </div>

                </div>


            </div>
            
            <div class="row margin-top20">

                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Rafael.png')}}" alt="Rafael Martin" onclick="modalText('Rafael');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Rafael');" class="colorBase1">

                            Rafael Martin

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        IT CONSULTANT
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Will.png')}}" alt="Will Rogich" onclick="modalText('Will');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Will');" class="colorBase1">

                            Will Rogich

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        CUSTOMER SUCCESS MANAGER
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Hansel.png')}}" alt="Hansel Sanez" onclick="modalText('Hansel');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Hansel');" class="colorBase1">

                            Hansel Sanez

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        CUSTOMER SUPPORT MANAGER
                    </div>

                </div>


            </div>
            
            <div class="row margin-top20">

                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Manuel.png')}}" alt="Manuel" onclick="modalText('Manuel');" class="cursor_pointer">
                    </div>

                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Manuel');" class="colorBase1">

                            Manuel Pijierro

                        </a>
                    </div>
                    <div class="text-12 text_center w600">
                        DEVELOPER
                    </div>

                </div>
                
                <div class="col-md-4 colorBase1">

                    

                </div>
                
                <div class="col-md-4 colorBase1">

                    <div class="text_center">
                        <img src="{{asset('assets/img/web/Team-Member-Hannah.png')}}" alt="Hannah" onclick="modalText('Hannah');" class="cursor_pointer">
                    </div>


                    <div class="fontRecoleta text-25 text_center">
                        <a onclick="modalText('Hannah');" class="colorBase1">
                            Hannah Smith
                        </a>
                    </div>

                    <div class="text-12 text_center w600">
                        CUSTOMER SUCCESS COORDINATOR
                    </div>

                </div>


            </div>

        </div>

    </section>
    
    <section id="section6_a">

        <div class="section6_a paddingSection">
            
            
            <div class="row w500 text-23">

                <div class="col-6 colorBase1 text_right zIndex100">
                    OUR PARTNERSHIPS
                </div>


                <div class=" borderLeftText col-6 colorBase2 zIndex100">
                    Better Together
                </div>
            </div>


            <div class="margin-top40 sayPartnerships">
                <div class="colorBase2 line_height1">
                    We don’t just sound like
                    <br><span class="colorBase1">we go together.</span>
                </div>

            </div>

            <div class="w500 realLifeCoaches colorBase1 text_right margin-top40">
                The <strong>LinguaMeeting</strong> / <strong>LingroLearning</strong> Partnership
            </div>

            <div class="divMichelle" id="divMaribelAbout">

                <div>
                    <img class="imgMichelleHS" src="{{asset('assets/img/web/MaribelPartnership.png')}}" alt="Maribel chuquichaico">
                </div>

            </div>
        </div>

    </section>
    
    
    <section id="section7_a">
        
        <div class="paddingSection">
            
            <div class="row colorBase1">
                
                <div class="col-md-6 padding20">
                    
                    <div class="fontRecoleta text-47">
                        Integration is here!
                    </div>
                    
                    <div class="margin-top20 text-21 colorBase2 line_height">
                        Two companies. One vision.
                    </div>
                    
                    <p class="text-21 margin-top40 line_height">
                        <strong>LinguaMeeting</strong> offers speaking practice with native-speaker coaches from around the world.
                    </p>
                    
                    <p class="text-21 margin-bottom40 line_height">
                        <strong>LingroLearning</strong> is a popular learning company that specializes in affordable, research-informed, interactive, and personalized language courses and experiences. 
                    </p>
                    
                    <div class="boxTextAbout">

                        <div class="colorBase2 fontRecoleta text-28">
                            “I can actually speak” 
                        </div>

                        <div class="separatorDivHome margin-top10">

                        </div>

                        <div class="colorBase1 line_height margin-top10 w500">
                            This is the first time I've learned a language in class where I feel like I can actually speak it and not just memorize some vocab. Is Spanish 3 run the same way as Spanish 1 & 2 like Contraseña, LinguaMeeting and Voicethreads? I feel pretty interested in taking it.
                        </div>

                        <div class="text_center colorBase1 margin-top40 w500">
                            Gray Hudson
                        </div>

                        <div class="text_center colorBase2 w500">
                            University of Florida
                        </div>

                    </div>

                </div>

                <div class="col-md-6 text-21 margin-top60 padding20">
                    
                    <div class="margin-top60">
                        <ul class="ulListNew line_height">
                            <li class="margin-top40">
                                <strong>Single sign-on and seamless scheduling.</strong> LinguaMeeting is available to students and instructors for any LingroLearning course and can be accessed directly from LingroHub.
                            </li>
                            
                            <li class="margin-top20">
                                <strong>A range of tailored prompts and activities.</strong>  Specific LinguaMeeting activities are tied to each unit's learning objectives and can be assigned and auto-graded to prepare students before, during, and after their conversation session with a coach.
                            </li>
                            
                            <li class="margin-top20">
                                <strong>Instant instructor feedback.</strong> Instructors receive instant feedback from their LinguaMeeting coaches and assess participation within the LingroHub Gradebook.
                            </li>
                        </ul>
                    </div>
                    
                    <div class="btnBasicTransparent textBtnLearnMore margin-top40 margin_auto w600">
                        <a href="{{route('contact')}}" class="colorBase4">
                            Schedule a Demo
                           
                        </a>
                    </div>
                    
                </div>
                
                
            </div>
            
            
        </div>
        
    </section>
    
    <section id="section8_a">
        
        <div class="section8_a paddingSection">
            
            <div class="text_center text-70 fontRecoleta">How it Works</div>
            
            <div class="colorBase1 text-22 margin-top20 line_height">
                <strong>Sync your classroom up seamlessly </strong>
                and say goodbye to a patchwork of platforms. Enjoy a multitude of resources for your courses all in one place!
            </div>
            
            <div class="row margin-top40">
                
                <div class="col-md-4">
                    
                    <div class="text_center">
                        <img src="{{asset('assets/img/web/about_how_1.png')}}" alt=" LinguaMeeting available">
                    </div>
                    
                    <div class="text_center text-21 margin-top10 line_height">
                        LinguaMeeting is available directly from your LingroHub course.
                    </div>
                    
                </div>
                
                <div class="col-md-4">
                    
                    <div class="text_center">
                        <img src="{{asset('assets/img/web/about_how_2.png')}}" alt=" LinguaMeeting available">
                    </div>
                    
                    <div class="text_center text-21 margin-top10 line_height">
                        Students register for a regularly scheduled session time on the registration page.
                    </div>
                    
                </div>
                
                <div class="col-md-4">
                    
                    <div class="text_center">
                        <img src="{{asset('assets/img/web/about_how_3.png')}}" alt=" LinguaMeeting available">
                    </div>
                    
                    <div class="text_center text-21 margin-top10 line_height">
                        Instructors monitor attendance, feedback from the coach, and recordings.
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </section>
    
    <section id="section9_a">
        
        <div class="paddingSection">
            
            <div class="row">
                
                <div class="col-md-6">
                    
                    <div class="colorBase1 w500">
                        READY TO EXPLORE?
                    </div>
                    
                    <div class="text-70 colorBase1 line_height1">
                        Contact Us!
                    </div>

                    <div class="btnBasicTransparent textBtnLearnMore margin-top40 w600">
                    <a href="{{route('contact')}}" class="colorBase4">
                            Schedule a Demo
                        
                    </a>
                        </div>

                </div>
                
                <div class="col-md-6">
                    
                    <div class="fontRecoleta text-47 colorBase1">
                        Integrate with ease
                    </div>
                    
                    <div class="text-21 colorBase1 margin-top40 line_height">
                        The partnership between <strong>LinguaMeeting</strong> and <strong>LingroLearning</strong> makes life so much easier for users of both! 
                    </div>
                    
                </div>
                
            </div>
            
            
        </div>
        
        
    </section>
    
    
</main>


<!-- MODAL TEXT -->
<div id="modal_viewAndrea" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Andrea.png')}}" alt="Andrea Calderon" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Andrea Calderon
                        </div>
                        <div class="text-12 text_center w600">
                            OPERATIONS COORDINATOR
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:andrea@linguameeting.com" class="colorBase2 text-21" title="Andrea Email">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Andrea believes that language is learned best as part of cultural exchange. Originally from Costa Rica, she was inspired by her experience at a cultural academy where she learned Portuguese to go on and found “Speaking School” in Seville, Spain. Today, Andrea supports students and faculty by creating courses and designing new interfaces for the LinguaMeeting platform.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewSandra" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Sandra.png')}}" alt="Sandra Campos" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Sandra Campos
                        </div>
                        <div class="text-12 text_center w600">
                            DEVELOPER
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:techsupport@linguameeting.com" class="colorBase2 text-21" title="Email Sandra">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Sandra has always loved learning new languages and getting to know new cultures and she’s currently learning Italian. With a background in technical engineering and data science, Sandra supports LinguaMeeting as a freelancer, coordinating and managing all programming tasks as well as server maintenance and security management.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewMaria" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Maria.png')}}" alt="María Centeno" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Maria J. Centeno

                        </div>
                        <div class="text-12 text_center w600">
                            EXPERIENCES COORDINATOR
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:maria.centeno@linguameeting.com" class="colorBase2 text-21" title="Email María Centeno">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Toward the end of her university studies in English in her home country of Ecuador, Maria was invited to work with students of Spanish, leading her to become a coach for LinguaMeeting. Eight years later, she’s enjoying learning about many different cultures and making lifelong friends around the world.
                        
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewMaribel" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Maribel.png')}}" alt="Maribel Chuquichaico" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Maribel Chuquichaico

                        </div>
                        <div class="text-12 text_center w600">
                           
                            QUALITY MANAGER + COACH SUPPORT
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:maribel@linguameeting.com" class="colorBase2 text-21" title="Email Maribel">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Maribel traveled from her home country of Peru to the US to teach Spanish—and from that moment, she knew she wanted to dedicate herself to teaching languages. Back in Cuzco, she started coaching for LinguaMeeting and now coordinates the training of coaches so they can offer language students the best language experience of their lives.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal_viewCarmen" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Carmen.png')}}" alt="Carmen Cidoncha" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Carmen Cidoncha

                        </div>
                        <div class="text-12 text_center w600">
                            OPERATION MANAGER
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:carmen@linguameeting.com" class="colorBase2 text-21" title="Email Carmen">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Carmen has always felt drawn to different languages ​​and cultures because she believes they promote more empathy and tolerance. She studied English in her native Spain and the UK, then managed a franchise of language schools in Barcelona. Carmen started working for LinguaMeeting where she now manages general operations. She loves working with the team to foresee possible issues and propose solutions.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewRafael" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Rafael.png')}}" alt="Rafael Martín" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Rafael Martin

                        </div>
                        <div class="text-12 text_center w600">
                            IT CONSULTANT
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:rafael@linguameeting.com" class="colorBase2 text-21" title="Email Rafael">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Rafa strives to continue learning every day. He works as an engineer and consultant for LinguaMeeting while simultaneously teaching computer science. He enjoys the dynamic nature of this work—continuously trying to improve functionality to meet the needs of faculty and students.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewWill" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Will.png')}}" alt="Will Rogich" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Will Rogich

                        </div>
                        <div class="text-12 text_center w600">
                            CUSTOMER SUCCESS MANAGER
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:will@linguameeting.com" class="colorBase2 text-21" title="Email Will">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        As a pre-med student, Will put off his Spanish requirement until his last semester. Once he finally did it, he fell in love with Spanish and its cultures and decided to forgo med school and move to Spain to get his MBA at the University of Seville. At LinguaMeeting, Will enjoys working with people who are passionate about changing people’s lives through languages.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewHansel" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Hansel.png')}}" alt="Hansel Sanez" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Hansel Sanez

                        </div>
                        <div class="text-12 text_center w600">
                           CUSTOMER SUPPORT MANAGER
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:hansel@linguameeting.com" class="colorBase2 text-21" title="Email Hansel">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        After studying English, Hansel saw how language learning could open doors to new countries and cultures. In his hometown of Lima, Perú, he worked as a systems engineer in a variety of industries before joining LInguaMeeting as a Spanish coach and, more recently, working in technical support. He enjoys his role in helping users solve problems and making his own language, country, and culture known.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewManuel" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right cursor_pointer" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Manuel.png')}}" alt="Manuel Pijierro" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Manuel Pijierro

                        </div>
                        <div class="text-12 text_center w600">
                            DEVELOPER
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:manuel@linguameeting.com" class="colorBase2 text-21" title="Email Manuel">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        Manuel is a technical engineer who is passionate about technology that inspires people to reach their personal and professional goals. After more than 15 years programming web applications, he landed at LinguaMeeting developing solutions for our users that improve productivity, satisfaction, and enjoyment of the experience learning languages. 
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal_viewHannah" class="hidden-print modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body colorBase1">

                <div class="padding20">
                    <div class="text-23 text_right" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times cursor_pointer"></i>
                    </div>
                </div>


                <div class="row">
                    
                    <div class="col-md-5 padding40">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/Team-Member-Hannah.png')}}" alt="Hannah Smith" class="imgPopUpTeam">
                        </div>

                        <div class="fontRecoleta text-25 text_center">
                            Hannah Smith

                        </div>
                        <div class="text-12 text_center w600">
                            CUSTOMER SUCCESS COORDINATOR
                        </div>
                        
                        <div class="colorBase2 text_center margin-top20">
                            <a href="mailto:hannah@linguameeting.com" class="colorBase2 text-21" title="Email Hannah">
                                <i class="far fa-envelope"></i>
                            </a>
                            
                        </div>

                    </div>
                    
                    <div class="col-md-7 padding40 w500 img_vertical line_height">
                        After studying Spanish and Secondary Education in university, Hannah went on to work as both a high school Spanish teacher in the US and an English teacher in Spain thanks to a Fulbright grant. She later went on to study a master's in Linguistics, Literary, and Cultural Studies at the University of Seville. At LinguaMeeting, Hannah enjoys working with professors to optimize possibilities for meaningful interaction in the target language within their classroom.
                    </div>
                    
                    
                </div>

            </div>
        </div>
    </div>
</div>

@include('common.web.footer')

</body>
</html>
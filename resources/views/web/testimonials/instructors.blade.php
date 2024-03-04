<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>
    
    <section id="section1_test">
        
        <div class="paddingSection section1_test backgroundColorBase2">
            
            <div class="iconTestimonialsSup">
                <img src="{{asset('assets/img/web/some-lingua-love.png')}}" alt="Some Lingua Love">
            </div>
            
            <div class="testimonialsVerticalLet">
                <img src="{{asset('assets/img/web/let-testimonials-vertical1.png')}}" alt="vertical line">
            </div>
            
            <div class="fontRecoleta text-72 colorWhite text_center line_height1">
                What They're <br>Saying 
            </div>
            
            <div class="row margin-top40">
                
                <div class="col-md-4">
                    <div class="marginTopMedia">
                        <div class="btnBasicRed textBtnLearnMore margin_auto w600">
                            <a href="{{url('testimonials/instructors')}}" class="colorWhite" alt="Instructors Testimonials">

                                Instructors

                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="marginTopMedia">
                        <div class="btnBasicWhiteNB textBtnLearnMore margin_auto w600">
                            <a href="{{url('testimonials/students')}}" class="colorBase4" alt="Students Testimonials">

                                Students

                            </a>
                        </div>
                    </div>
                </div><!-- comment -->
                <div class="col-md-4">
                    <div class="marginTopMedia">
                        <div class="btnBasicWhiteNB textBtnLearnMore margin_auto w600">
                            <a href="{{url('testimonials/coaches')}}" class="colorBase4" alt="Coaches Testimonials">

                                Coaches

                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="row margin-top40">
                
                <div class="col-md-6">
                    
                    <div class="boxTestimonial">
                        <div class="colorBase1 w500 line_height">
                            “I absolutely LOVE this program! My students are wondering why the sessions can’t be longer, or they can’t do this twice a week. I’m getting amazing feedback from them.”
                        </div>
                        
                        <div class="colorBase1 margin-top20">
                            <strong>Prof. Lissette Castro</strong>
                        </div>
                        <div class="colorBase2 w600">
                            Mt San Jacinto College
                        </div>
                    </div>
                    
                    <div class="boxTestimonial">
                        
                        <div class="position_relative">
                            
                            <div>
                                <img src="{{asset('assets/img/web/kate-testimonial.png')}}" alt="kate testimonial">
                            </div>
                            <div class="cursor_pointer divgGuyLogoPlayTestInst">
                                <a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM2T5gCjQkEQ5rrZXcyuN7MB" target="_blank" title="Kate Testimonial">
                                    <img class="imgAbsPlay" src="{{asset('assets/img/web/Video-Play-button-Solid-Drop-Shadow.png')}}" alt="Play Logo" >
                                </a>
                            </div>
                            
                        </div>
                        
                        <div class="colorBase1 w500 margin-top60 line_height">
                            “It was fun today meeting with my F2F class after their first LM session. It was awesome to incorporate what they talked about and learned with their coaches into the class. They were able to tell me their coach's name, where they are from and share an additional detail about them. It's just so cool - next level!”
                        </div>

                        <div class="colorBase1 margin-top20">
                            <strong>Kate Brooke</strong>
                        </div>
                        <div class="colorBase2 w600">
                            Texas Tech University
                        </div>
                    </div>
                    
                    <div class="boxTestimonial">
                        <div class="colorBase1 w500 line_height">
                            “The coaching eliminates listening to student recordings; instead of listening we can now watch our student videos, where we see the students interact.”
                        </div>
                        
                        <div class="colorBase1 margin-top20">
                            <strong>Prof. Helga Winkler</strong>
                        </div>
                        <div class="colorBase2 w600">
                            Moorpark Community College
                        </div>
                    </div>
                    
                    
                </div>
                
                <div class="col-md-6">
                    
                    <div class="boxTestimonial">
                        <div class="colorBase1 w500 line_height">
                            “LinguaMeeting facilitates the integration of Virtual Exchange into your foreign language course in an easy and practical way. These interactions with native speakers help students achieve ACTFL’s goal areas and standards in a low-anxiety and fun atmosphere. I highly recommend it from high elementary to advanced courses.”
                        </div>
                        
                        <div class="colorBase1 margin-top20">
                            <strong>Maripaz Garcia</strong>
                        </div>
                        <div class="colorBase2 w600">
                            First Year Coordinator at Yale University
                        </div>
                    </div>
                    
                    <div class="margin-top60 boxConnectTestimonialInst">

                         <div class="fontRecoleta padding-top20 colorWhite text-26">

                             <div class="padding20">
                                 Wondering how to effortlessly incorporate LinguaMeeting into your classroom?
                             </div>


                         </div>

                         <div class="padding-right20">
                             <div class="btnBasicTransparentLong textBtnLearnMore w500 cursor_pointer float_right">
                                 <a href="{{url('case-study/kate')}}" target="_blank" class="colorBase4" title="Case Study Kate">
                                     View Case Studies
                                 </a>
                             </div>
                         </div>

                     </div>
                    
                    <div class="margin-top60 boxConnectTestimonialMedia text-26">

                         <div class="fontRecoleta padding-top20 colorBase1">

                             <div class="padding20">
                                 Wondering how to effortlessly incorporate LinguaMeeting into your classroom?
                             </div>


                         </div>

                         <div class="padding20">
                             <div class="btnBasicWhite textBtnLearnMore w500 cursor_pointer float_right">
                                 <a href="{{url('case-study/kate')}}" target="_blank" class="colorBase4" title="Case Study Kate">
                                     View Case Studies
                                 </a>
                             </div>
                         </div>

                     </div>
                    
                    
                    <div class="boxTestimonial">
                        <div class="colorBase1 w500 line_height">
                            “There’s lots of research on this: frequent pleasant interactions with native speakers can create that internal motivation for students to want to try more. That’s the biggest benefit.”
                        </div>
                        
                        <div class="colorBase1 margin-top20">
                            <strong>Jill Pelletieri</strong>
                        </div>
                        <div class="colorBase2 w600">
                            Santa Clara University
                        </div>
                    </div>
                    
                    <div class="margin-top60 text_center margin-bottom40">

                        <img src="{{asset('assets/img/web/our-mission-testimonial-student.png')}}" alt="Our Mission">

                     </div>
                    
                    <div class="boxTestimonial">
                        <div class="colorBase1 w500 line_height">
                            “Students love LinguaMeeting.... at the beginning they really struggle and don't want to do it. By the end they always tell me how useful it was.”
                        </div>
                        
                        <div class="colorBase1 margin-top20">
                            <strong>Luisa Baez</strong>
                        </div>
                        <div class="colorBase2 w600">
                            University of Southern Mississippi
                        </div>
                    </div>
                    
                    
                </div>
                
            </div>
            
            
        </div>
        
    </section>
    
    
</main>

@include('common.web.footer')

</body>
</html>
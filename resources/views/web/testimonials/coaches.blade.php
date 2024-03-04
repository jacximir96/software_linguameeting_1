<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>

    <section id="section1_test">

        <div class="paddingSection section1_test backgroundColorBase1">

            <div class="iconTestimonialsSup">
                <img src="{{asset('assets/img/web/some-lingua-love-red.png')}}"  alt="Some Lingua Love">
            </div>

            <div class="testimonialsVerticalLet">
                <img src="{{asset('assets/img/web/let-testimonials-vertical3.png')}}" alt="Vertical Line">
            </div>

            <div class="fontRecoleta text-72 colorBase2 text_center">
                What They're <br>Saying 
            </div>

            <div class="row margin-top40">

                <div class="col-md-4">
                    <div class="marginTopMedia">
                        <div class="btnBasicWhiteNB textBtnLearnMore margin_auto w600">
                            <a href="{{url('testimonials/instructors')}}" class="colorBase4" alt="Instructors Testimonials">

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
                        <div class="btnBasicRed textBtnLearnMore margin_auto w600">
                            <a href="{{url('testimonials/coaches')}}" class="colorWhite" alt="Coaches Testimonials">

                                Coaches

                            </a>
                        </div>
                    </div>
                </div>

            </div>

            
            <!-- BRENDA GUERRA -->
            <div class="boxTestimonialCoach" id="testimonialSpanish1">

                <div class="row">

                    <div class="col-md-6 text-center w500">

                        <div class="text_center">
                            <img src="{{asset('assets/img/web/brenda-testimonial.png')}}" alt="Brenda Guerra">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Me siento orgullosa de compartir mis raíces”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Brenda Guerra
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Guatemala</strong>
                        </div>

                    </div>

                    <div class="col-md-6 text-right">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            Pertenezco a la comunidad indígena Kaqchikel, en casa hablamos la lengua nativa “kaqchikel” y español. Me siento orgullosa de pertenecer a una familia indigena y me encanta usar mi traje típico, sin embargo en la escuela donde trabajaba antes me lo prohibieron. En LinguaMeeting tengo la oportunidad de usarlo cuando hablamos sobre los trajes tradicionales, ver la emoción e interés de los estudiantes es indescriptible.
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer float_right" onclick="translateTestimonial('english', 1);">
                            Translate to English
                        </div>

                    </div>

                </div>

            </div>

            <div class="boxTestimonialCoach notDisplay" id="testimonialEnglish1">

                <div class="row">

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/brenda-testimonial.png')}}" alt="Brenda Guerra">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Me siento orgullosa de compartir mis raíces”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Brenda Guerra
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Guatemala</strong>
                        </div>

                    </div>

                    <div class="col-md-6 text-right">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            I am a part of the Kaqchikel indigenous community. In my home we speak the native language "kaqchikel" as well as Spanish. I am proud to belong to an indigenous family and I love to wear our traditional clothing, however, at the school where I used to work, they prohibited me from doing so. At LinguaMeeting I have the opportunity to use my traditional dress when we talk about traditional costumes. Seeing the excitement and interest of the students is indescribable.
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer float_right" onclick="translateTestimonial('spanish', 1);">
                            Translate to Spanish
                        </div>

                    </div>

                </div>

            </div>

            <!-- CARMEN SANEZ -->
            <div class="boxTestimonialCoach margin-top20" id="testimonialSpanish2">

                <div class="row">


                    <div class="col-md-6">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            Estoy pendiente de mi hogar, mi trabajo y mis estudios, pero sobre todo de mi hijo de 8 años, en mi anterior trabajo llegaba a casa cuando estaba durmiendo, pero ahora puedo pasar más tiempo con él, atenderlo, cocinarle, llevarlo a sus terapias de lenguaje y ayudarlo con sus tareas del colegio. Puedo decir que he encontrado un verdadero balance en mi vida desde que trabajo en LinguaMeeting.
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer" onclick="translateTestimonial('english', 2);">
                            Translate to English
                        </div>

                    </div>

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/carmen-testimonial.png')}}" alt="Carmen Sanez">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “He encontrado un verdadero balance”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Carmen Sanez
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Peru</strong>
                        </div>

                    </div>


                </div>

            </div>
            
            <div class="boxTestimonialCoach notDisplay" id="testimonialEnglish2">

                <div class="row">



                    <div class="col-md-6">

                        <div class="colorBase1 margin-top60 w500 line_height">
                           I am kept busy with tasks around the house, my work and my studies, but above all by my 8-year-old son. At my previous job, I got home when he was sleeping. Now, I can spend more time with him, take care of him, cook for him, take him to his speech therapy appointments and help him with his homework. I am happy to say that I have found a true work-life balance since I joined LinguaMeeting.
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer" onclick="translateTestimonial('spanish', 2);">
                            Translate to Spanish
                        </div>

                    </div>

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/carmen-testimonial.png')}}" alt="Carmen Sanez">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “He encontrado un verdadero balance”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Carmen Sanez
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Peru</strong>
                        </div>
                    </div>

                </div>

            </div>

            <!-- GISELLE LIMAS -->
            <div class="boxTestimonialCoach" id="testimonialSpanish3">

                <div class="row">

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/giselle-testimonial.png')}}" alt="Giselle Limas">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Los estudiantes distraen mi mente y me hacen feliz”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Giselle Limas
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Honduras</strong>
                        </div>

                    </div>

                    <div class="col-md-6 text-right">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            “Los estudiantes distraen mi mente y me hacen feliz”
LinguaMeeting me ha ayudado a salir de la depresión y ansiedad, desde que trabajo con estudiantes mi mente se distrae, siempre me concentro y los escucho atentamente, también me divierto leyendo sobre los temas de conversación y realizando materiales. Siempre busco dar lo mejor de mí, me siento muy bien cuando veo que mis estudiantes son agradecidos o veo una sonrisa en su rostro.

                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer float_right" onclick="translateTestimonial('english', 3);">
                            Translate to English
                        </div>

                    </div>

                </div>

            </div>

            <div class="boxTestimonialCoach notDisplay" id="testimonialEnglish3">

                <div class="row">

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/giselle-testimonial.png')}}" alt="Giselle Limas">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Los estudiantes distraen mi mente y me hacen feliz”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Giselle Limas
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Honduras</strong>
                        </div>

                    </div>

                    <div class="col-md-6 text-right">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            “Students are a happy distraction!” 
LinguaMeeting has helped me overcome depression and anxiety. Working with students allows one’s mind to explore new ideas. I always concentrate and listen to my students carefully, and I truly enjoy reading about conversation topics and preparing class materials. I always seek to do my best, and I am gratified when I see that my students are thankful for our sessions and have a smile on their face.

                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer float_right" onclick="translateTestimonial('spanish', 3);">
                            Translate to Spanish
                        </div>

                    </div>

                </div>

            </div>
            
            
            <!-- BERTILA -->
            <div class="boxTestimonialCoach margin-top20" id="testimonialSpanish4">

                <div class="row">


                    <div class="col-md-6">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            Toqué las puertas de varias empresas, pero sin éxito. A pesar de graduarme con honores no me dieron la oportunidad, debía tener al menos 2 años de experiencia para ser aceptada. Cuando las esperanzas y la desilusión se apoderaban de mí, me ofrecieron la oportunidad de ser coach de español y sin dudarlo acepté. Ya llevó más de 5 años trabajando para LinguaMeeting y espero que sean muchos más. 
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer" onclick="translateTestimonial('english', 4);">
                            Translate to English
                        </div>

                    </div>

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/bertila-testimonial.png')}}" alt="Bertila Rodriguez">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “LinguaMeeting fue mi 1er trabajo”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Bertila Rodriguez
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Guatemala</strong>
                        </div>

                    </div>


                </div>

            </div>

            
            <div class="boxTestimonialCoach notDisplay" id="testimonialEnglish4">

                <div class="row">



                    <div class="col-md-6">

                        <div class="colorBase1 margin-top60 w500 line_height">
                           After finishing school, I applied to various job openings at several companies, but was unsuccessful. Despite graduating with honors, companies would not give me a chance because I had to have at least 2 years of work experience to be accepted. When hope and disappointment took hold of me, I was offered the opportunity to be a Spanish Coach with LinguaMeeting, which I accepted without hesitation. I have been working with LinguaMeeting for more than 5 years now and I look forward to many more to come!
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer" onclick="translateTestimonial('spanish', 4);">
                            Translate to Spanish
                        </div>

                    </div>

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/bertila-testimonial.png')}}" alt="Bertila Rodriguez">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “LinguaMeeting fue mi 1er trabajo”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Bertila Rodriguez
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Guatemala</strong>
                        </div>
                    </div>

                </div>

            </div>
            
            
            <!-- VALDE PIE -->
            <div class="boxTestimonialCoach" id="testimonialSpanish5">

                <div class="row">

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/valde-testimonial.png')}}" alt="Valde Pie">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Desde niño supe que debía esforzarme”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Valde Pie
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>República Dominicana</strong>
                        </div>

                    </div>

                    <div class="col-md-6 text-right">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            Me crié en un orfanato y desde niño supe que mi camino no iba a ser fácil. Me gradué de la universidad, pero si tienes una historia como la mía es muy poco probable que las empresas te contraten. LinguaMeeting confío en mí y me abrió las puertas de su institución, ahora hay muchos estudiantes que alaban mi energía y mi forma de ver con positivismo la vida. 
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer float_right" onclick="translateTestimonial('english', 5);">
                            Translate to English
                        </div>

                    </div>

                </div>

            </div>

            <div class="boxTestimonialCoach notDisplay" id="testimonialEnglish5">

                <div class="row">

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/valde-testimonial.png')}}" alt="Valde Pie">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Desde niño supe que debía esforzarme”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Valde Pie
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>República Dominicana</strong>
                        </div>

                    </div>

                    <div class="col-md-6 text-right">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            I grew up in an orphanage and since I was a child I knew that the road ahead was not going to be an easy one. I graduated from university, but with a background like mine, it is highly unlikely that a company will hire you. LinguaMeeting trusted me and opened their doors for me to grow professionally. I am lucky to work with many students who connect with my energy and admire my ability to see the positive side of life. 
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer float_right" onclick="translateTestimonial('spanish', 5);">
                            Translate to Spanish
                        </div>

                    </div>

                </div>

            </div>
            

            <!-- DANIELA MADRID -->
            <div class="boxTestimonialCoach margin-top20" id="testimonialSpanish6">

                <div class="row">


                    <div class="col-md-6">

                        <div class="colorBase1 margin-top60 w500 line_height">
                            En mi país, a los hombres les cuesta aceptar que una mujer sea la líder, fui supervisora en mi anterior trabajo y nunca me dieron mi lugar. Me di cuenta que las mujeres deben esforzarse mucho más y eso es algo que admiro mucho de LinguaMeeting, ya que es una empresa que está liderada por mujeres, desde las fundadoras y el equipo de trabajo. Trabajar en esta empresa es una fuente de inspiración y motivación.
                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer" onclick="translateTestimonial('english', 6);">
                            Translate to English
                        </div>

                    </div>

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/daniela-testimonial.png')}}" alt="Daniela Madrid">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Me siento empoderada”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Daniela Madrid
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Colombia</strong>
                        </div>

                    </div>


                </div>

            </div>
            
            <div class="boxTestimonialCoach notDisplay" id="testimonialEnglish6">

                <div class="row">

                    <div class="col-md-6">

                        <div class="colorBase1 margin-top60 w500 line_height">
                           In my country, men have a hard time accepting women as leaders. I worked as a supervisor in my previous job and my role was never respected. I came to understand that women have to work much harder to accomplish the same goals as men. Something I admire a lot about LinguaMeeting is that it is a women-led company, from the founders to the administrative team. Working with LinguaMeeting is a huge source of inspiration and motivation.

                        </div>

                        <div class="btnBasicWhiteLong textBtnLearnMore margin-top60 w500 cursor_pointer" onclick="translateTestimonial('spanish', 6);">
                            Translate to Spanish
                        </div>

                    </div>

                    <div class="col-md-6 text-center w500">

                        <div>
                            <img src="{{asset('assets/img/web/daniela-testimonial.png')}}" alt="Daniela Madrid">
                        </div>

                        <div class="colorBase1 text-26 margin-top20">
                            “Me siento empoderada”
                        </div>

                        <div class="colorBase1 margin-top40 text-18">
                            Daniela Madrid
                        </div>
                        <div class="colorBase2">
                            Coach de Español
                        </div>
                        <div class="colorBase2">
                            <strong>Colombia</strong>
                        </div>
                    </div>

                </div>

            </div>
            
            <div class="margin-top60 boxConnectTestimonial">

                <div class="fontRecoleta padding-top20 colorWhite">

                    <div class="padding20">
                        Interested in becoming a coach? We’d love to hear from you!
                    </div>


                </div>

                <div class="padding20">
                    <div class="btnBasicTransparent textBtnLearnMore w500 cursor_pointer float_right">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSekBcb0jDq_gqf9fX585TxBEAeEyFP2K0pfu1sVT4jUzwdw_g/viewform" target="_blank" class="colorBase4" title="Doc Form Google">
                            Let's Connect
                        </a>
                    </div>
                </div>

            </div>
            
            <div class="margin-top60 boxConnectTestimonialMedia text-26">

                <div class="fontRecoleta padding-top20 colorWhite">

                    <div class="padding20">
                        Interested in becoming a coach? We’d love to hear from you!
                    </div>


                </div>

                <div class="padding20">
                    <div class="btnBasicWhite textBtnLearnMore w500 cursor_pointer float_right">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSekBcb0jDq_gqf9fX585TxBEAeEyFP2K0pfu1sVT4jUzwdw_g/viewform" target="_blank" class="colorBase4" title="Doc Form Google">
                            Let's Connect
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </section>

    
</main>

@include('common.web.footer')

</body>
</html>
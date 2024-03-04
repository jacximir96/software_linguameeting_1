<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.web.head')
</head>
<body>

@include('common.web.header')
<main>
    
    <section id="section1_p">
        
        <div class="paddingSection">
            
            <div class="text-70 colorBase1 text_center line_height1">
                A personal language 
                <br>coach <span class="colorBase2">for every student at</span>
                <br>a price that makes sense.
            </div>
            
        </div>
        
    </section>
    
    <section id="section2_p">
        
        <div class="paddingSection">
            
            <div class="row">

                <div class="col-md-4 colorBase1 text-21 line_height">

                    <p>
                        <strong>
                            Individual:
                            <br><span class="colorBase2">As low as $10 per session</span>
                        </strong>
                        <br>
                        <strong>
                            Small group:
                            <br><span class="colorBase2">As low as $5 per session</span>
                        </strong>

                    </p>

                    <p>
                        <strong>We believe in the value we bring to language learners</strong> and we’re also sensitive to the struggle of students trying to pay for their education.
                    </p>

                    <p>
                        So we've structured our pricing in a way that supports our stellar coaches and gives students options. 
                    </p>

                    <p>
                        <strong>Try our Pricing Estimator</strong> to get a sense of how much students would pay per semester.
                    </p>

                    <div class="btnBasicTransparent textBtnLearnMore margin-top40">
                        <a href="{{asset('assets/documents/LinguaMeetingPricing.pdf')}}" target="_blank" class="colorBase4 w600" title="LinguaMeeting pricing">
                            
                                Pricing

                        </a>
                    </div>

                </div>

                <div class="col-md-8">

                    <div class="boxEstimator marginTopMedia">
                        
                        <div class="backgroundColorBase1 colorWhite text_center boxEstimatorHead">
                            <div class="">
                                LET'S RUN THE NUMBERS
                            </div>
                            <div class="fontRecoleta text-65">
                                Price Estimator
                            </div>
                        </div>

                        <div class="boxEstimatorBody">
                            <div class="margin-top20 colorBase1">

                                <select class="formPricingLingua selectTypePricing" id="selectType">
                                    <option value="0" selected>Session Type</option>
                                    <option value="SG">Small-Group</option>
                                    <option value="O">Individual</option>
                                </select>

                            </div>

                            <div class="margin-top20 colorBase1">

                                <select class="formPricingLingua selectTypePricing" id="selectDuration">
                                    <option value="0" selected>Session Duration</option>
                                    <option value="15">15 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                </select>

                            </div>

                            <div class="margin-top20 colorBase1">

                                <select class="formPricingLingua" id="selectNumber">
                                    <option value="0" selected>Number of Sessions</option>
                                    <option value="12">12</option>
                                    <option value="11">11</option>
                                    <option value="10">10</option>
                                    <option value="9">9</option>
                                    <option value="8">8</option>
                                    <option value="7">7</option>
                                    <option value="6">6</option>
                                    <option value="5">5</option>                        
                                    <option value="4">4</option>                        
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>

                            </div>

                            <div class="margin-top20 colorBase1 w500">
                                <input type="checkbox" class="" id="unlimetedExperiences" name="unlimetedExperiences" value="unlimited">
                                <label for="unlimetedExperiences">Add unlimited access to <strong>Experiences</strong></label><br>
                            </div>
                            
                            <div class="margin-top20 colorBase4 w500" id="resultPricingSearch">
                                
                            </div>

                            <div class="text_right colorBase2">

                                <div class="text-65">$<span id="resultEstimator"></span></div>
                                <div>Price Per Student</div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            
        </div>
        
    </section>
    
    <section id="section3_p">
        
        <div class="paddingSection section3_p">
            
            <div class="iconBreakDown">
                <img src="{{asset('assets/img/web/break_down.png')}}" alt="break down image">
            </div>

            <div class="row">

                <div class="col-md-8">

                    <div class="fontRecoleta text-70 colorWhite line_height1 margin-top60">
                        One-On-One vs. 
                        <br>Small-Group
                    </div>

                    <div class="text-21 colorWhite margin-top40 line_height">
                        Choose between One-On-One or Small-Group sessions for your students. One-On-One sessions are beneficial for upper-level students; whereas, intro-level learners often prefer small groups (usually 2-3 students per coach) so they can ease into communication practice.
                    </div>

                </div>

                <div class="col-md-4 text_center">
                    <div class="margin-top60">
                        <img src="{{asset('assets/img/web/pricing_pc.png')}}" alt="computers image pricing">
                    </div>
                </div>
            </div>
            
        </div>
        
    </section>
    
    
    <section id="section4_p">
        
        <div class="paddingSection section4_p">
            
            <div class="row">
                
                <div class="col-md-4 text_center">
                    <div class="margin-top60">
                        <img src="{{asset('assets/img/web/clock.png')}}" alt="clock image pricing">
                    </div>
                </div>
                
                <div class="col-md-8">

                    <div class="fontRecoleta text-70 colorWhite text_right line_height1 marginTopMedia">
                        Session Duration
                    </div>
                    
                    <div class="separatorDivPricing margin-top20 float_right">

                        </div>

                    <div class="text-21 colorBase1 margin-top40 text_right line_height">
                        It may be hard to believe, but <strong>15 minutes</strong> truly does fly by! We have many intro courses that choose to do <strong>30 minutes</strong>, 
                        once per week. Our coaches are trained to fill the time with meaningful, useful practice so that students are engaged and learning a ton. 
                        For higher levels, <strong>45-minute sessions</strong> are wonderful. And we do get requests for 60-minute sessions but aren’t offering that… yet!
                    </div>

                </div>
            </div>
            
        </div>
        
    </section>
    
    <section id="section5_p">
        
        <div class="paddingSection section5_p">
            
            <div class="row">

                <div class="col-md-8">

                    <div class="fontRecoleta text-70 colorWhite line_height1">
                        No. of Sessions per
                        <br>Semester
                    </div>
                    
                    <div class="separatorDivPricing margin-top20">

                        </div>

                    <div class="text-21 colorWhite margin-top40 line_height">
                        The frequency of sessions per week or month is purely up to you. 
                        Many instructors choose to have students meet with their coaches weekly; others prefer more like once a month. 
                        <strong>We're happy to consult with you on these decisions</strong>.
                    </div>
                    
                    <div class="btnBasicRedLong textBtnLearnMore margin-top40">
                        <a href="{{route('contact')}}" class="colorWhite" title="Contact us">
                            
                            Schedule a chat with us!
                            
                        </a>
                    </div>

                </div>

                <div class="col-md-4 text_center">
                    <div class="margin-top60">
                        <img src="{{asset('assets/img/web/calendar.png')}}" alt="calendar image pricing">
                    </div>
                </div>
            </div>
            
        </div>
        
    </section>
    
    <section id="section6_p">
        
        <div class="paddingSection section6_p">
            
            <div class="row">
                
                <div class="col-md-4 text_center">
                    <div class="margin-top60">
                        <img src="{{asset('assets/img/web/world.png')}}" alt="world image pricing">
                    </div>
                </div>
                
                <div class="col-md-8">

                    <div class="fontRecoleta text-70 colorBase2 text_right line_height1 marginTopMedia">
                        Unlimited access to
                        <br>Experiences
                    </div>
                    
                    <div class="separatorDivPricing margin-top20 float_right">

                        </div>

                    <div class="text-21 colorBase1 margin-top40 text_right line_height">
                        This is <strong>an incredibly valuable add-on that expands students' exposure to a variety of cultural topics</strong>,
                        presented live via Zoom from various locations around the world. We typically offer multiple presentations per month and students can sign up for any and all of them if this add on is selected by instructors.
                    </div>

                </div>
            </div>
            
        </div>
        
    </section>
    
</main>

@include('common.web.footer')

</body>
</html>


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
            
            <div class="colorBase1 fontRecoleta text-72 text_center">
                Contact Us

            </div>
            
            <div class="text_center colorBase1 w500">
                Whether you have a question about features, trials, pricing, need a demo, or anything else, <strong>our team is ready to answer all your questions</strong>.
            </div>
            
            <div class="margin-top60 colorBase1 w500 text_center">
                SELECT ONE
            </div>
            
            <div class="text_center fontRecoleta colorBase1 text-32">
                <div class="btn-group borderBottomText2">
                    <div class="text_center colorBase2" id="changeNameContact" value="Instructor">I'm an Instructor</div>


                    <div class="cursor_pointer colorBase2 w300 marginArrowContact" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Professor');">Professor</div>
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Instructor');">Instructor</div>
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('DepartmentChair');">Department Chair</div>
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('CourseCoordinator');">Course Coordinator</div>                    
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Student');">Student</div>
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Individual');">Independent Learner</div>
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Other');">Other</div>
                    </div>
                </div>
            </div>

        </div>
        
        
        <div class="boxContact colorBase1 w500">

            <div class="text-23">
                <strong>Send us a Message</strong>
            </div>

            <form>
                <div class=" margin-top40">
                    <label>
                        Name *
                    </label>
                    <input type="text" class="formContactLinguaSmall" id="name" name="name" value="" placeholder="">
                </div>
                <div class="margin-top20">
                    <label>
                        Last Name
                    </label>
                    <input type="text" class="formContactLinguaSmall" name="lastname"  id="lastname" value="" placeholder="">
                </div>
                <div class="margin-top20">
                    <label>
                        Email *
                    </label>
                    <input type="email" class="formContactLinguaSmall" name="email"  id="email" value="" placeholder="">
                </div>
                
                <div class="margin-top20">

                    <label for="issuetype">Issue Type: *</label>
                    <select class="formContactLinguaSmall" id="issuetype" name="issuetype" required>
                        <option value="0" selected>Please select one</option>                        
                        <option value="17">Registration</option>
                        <option value="35">Payments</option>
                        <option value="37">Scheduling</option>
                        <option value="34">Make-ups</option>
                        <option value="32">Tech Issues</option>
                        <option value="33">Other</option>
                    </select>

                </div>
                
                <div class="margin-top20">
                    <label>
                        School/Company
                    </label>
                    <input type="text" class="formContactLingua" name="school_company" id="school_company" value="" placeholder="">
                </div>
                <div class="margin-top20">
                    <label>
                        Message *
                    </label>
                    <textarea class="formContactLingua" name="message" id="message" rows="3" placeholder=""></textarea>
                </div>
                
                

                <div class="margin-top20">
                    
                    <input type="file" id="file" name="file" class="inputFileContact" data-multiple-caption="{count} files selected">
                    <label class="borderBottomText cursor_pointer"  for="file">
                        <strong>Upload a File</strong>

                    </label>
                </div>
            </form>
            <div class="margin-bottom40">
                <div class="text_right btnBasicRed w600 float_right">
                <a ng-click="contactForm()" class="colorWhite">
                        Send
                    </a>
            </div>
            </div>

        </div>

    </section>
    
    <section>
        
        <div class="section2_contact paddingSection" title="Background green">
            
            <div class="marginContactBox colorWhite text_center">
                
                <div class="fontRecoleta text-62">
                    Still Have Questions?
                </div>
                
                <div class="text-21">
                    We have answers.
                </div>
                
                <div class="margin-top20" >
                    <div class="btnBasicTransparentWhite w600 margin_auto">
                        <a href="{{route('support')}}" class="btnBasicWith colorWhite ">
                            Support

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
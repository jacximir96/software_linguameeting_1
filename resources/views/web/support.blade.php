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
            <div class="colorBase1 text-70 text_center fontRecoleta">
                Have Questions? 
            </div>
            
            <div class="colorBase1 text-21 text_center">
                Whether you are an instructor or a student, find the answer to the most common questions in our knowledge base.
            </div>

            <div class="margin-top40 inputSearch margin_auto">
                <div class="input-group ">
                    <input type="text" class="form-control" id="searchQuery" placeholder="Search our knowledge base" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text cursor_pointer" id="basic-addon2" ng-click="searchJira()">Search</span>
                    </div>
                </div>

            </div>

            
            <div id="resultSearch">
                
                
            </div>


            <div class="text_center fontRecoleta colorBase1 text-32 margin-top40">
                <div class="btn-group borderBottomTextBasic2">
                    <div class="text_center colorBase2" id="changeNameContact" value="Instructor">I'm an Instructor</div>


                    <div class="cursor_pointer colorBase2 w300 marginArrowContact" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Instructor');">Instructor</div>
                        <div class="dropdown-item colorBase1 text-32 cursor_pointer" onclick="changeNameContact('Student');">Student</div>
                    </div>
                </div>
            </div>
            
            
            <div id="envelopeInstructorSupport" class="margin-top40">
                <div class="row">

                    <div class="col-md-6">

                        <div class="boxSupport">

                            <div class="colorBase2 fontRecoleta text-28 w500">

                                Getting Started

                            </div>

                            <div class="separatorDivHome margin-top10">

                            </div>

                            <div class="margin-top20 padding20">
                                <ul>

                                    <li class="colorBase1">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1909522433" target="_blank" class="colorBase1 w500 borderBottomTextBasic">What information is required to set-up my course?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1861124097" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do instructors create a new course? </a>
                                    </li><!-- comment -->

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1862762497" target="_blank" class="colorBase1 w500 borderBottomTextBasic">What are the different conversation guide options?</a>
                                    </li>


                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1919680513" target="_blank" class="colorBase1 w500 borderBottomTextBasic">What are the different instructor roles?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1791033345" target="_blank" class="colorBase1 w500 borderBottomTextBasic">What is the session booking policy?</a>
                                    </li>


                                </ul>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 marginTopMedia">

                        <div class="boxSupport">

                            <div class="colorBase2 fontRecoleta text-28 w500">

                                During the Course

                            </div>

                            <div class="separatorDivHome margin-top10">

                            </div>

                            <div class="margin-top20 padding20">
                                <ul>

                                    <li class="colorBase1">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1871904769" target="_blank" class="colorBase1 w500 borderBottomTextBasic">
                                            How do instructors view students' scheduled sessions?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1790279681" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do instructors adjust students' weekly session deadline?</a>
                                    </li><!-- comment -->

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1869512705" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do instructors add make-ups for purchase for students?</a>
                                    </li>


                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1886912513" target="_blank" class="colorBase1 w500 borderBottomTextBasic">Instructors Portal: How to use course actions</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1860698125" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How can an instructor view & modify coach feedback?</a>
                                    </li>


                                </ul>
                            </div>

                        </div>

                    </div>
                    
                </div>

            </div>


            <div id="envelopeStudentSupport" class="margin-top40 notDisplay">
                <div class="row">

                    <div class="col-md-6">

                        <div class="boxSupport">

                            <div class="colorBase2 fontRecoleta text-28 w500">

                                Getting Started

                            </div>

                            <div class="separatorDivHome margin-top10">

                            </div>

                            <div class="margin-top20 padding20">
                                <ul>

                                    <li class="colorBase1">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1904476161" target="_blank" class="colorBase1 w500 borderBottomTextBasic">What will I talk about with my coach?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1904672769" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How am I being graded?</a>
                                    </li><!-- comment -->

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/14319618" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do I register for my course?</a>
                                    </li>


                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/14417933" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do I access my course using a bookstore code?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1791033345" target="_blank" class="colorBase1 w500 borderBottomTextBasic">What is the session booking policy?</a>
                                    </li>


                                </ul>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 marginTopMedia">

                        <div class="boxSupport">

                            <div class="colorBase2 fontRecoleta text-28 w500">

                                During the Course

                            </div>

                            <div class="separatorDivHome margin-top10">

                            </div>

                            <div class="margin-top20 padding20">
                                <ul>

                                    <li class="colorBase1">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1791033345" target="_blank" class="colorBase1 w500 borderBottomTextBasic">
                                            What are the participation expectations for sessions?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1860763669" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do I book my sessions?</a>
                                    </li><!-- comment -->

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1860960264" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How do I join a session?</a>
                                    </li>


                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/15302681" target="_blank" class="colorBase1 w500 borderBottomTextBasic">Can I see my session recordings?</a>
                                    </li>

                                    <li class="margin-top20">
                                        <a href="https://linguameeting.atlassian.net/servicedesk/customer/portal/1/article/1877082113" target="_blank" class="colorBase1 w500 borderBottomTextBasic">How can I book a make-up session?</a>
                                    </li>


                                </ul>
                            </div>

                        </div>

                    </div>
                    
                </div>

            </div>
            
            <div class="text-54 text_center margin-top60 colorBase2 w500">
                Can't find the answer? <a href="contact" class="colorBase1">Contact us!</a>
            </div>

        </div>
    </section>

    
</main>

@include('common.web.footer')

</body>
</html>
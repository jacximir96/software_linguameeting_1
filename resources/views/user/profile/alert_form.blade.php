@extends('layouts.app')

@section('content')

<div class="row mb-5">
    
    <div class="col-md-12">

        <div class="card">

            <div class="card-body float-none">
                
                <div class="">
                    <div class="title-dashboard-circle float-start">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" fill="white" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/></svg>
                        
                    </div>

                    <div class="title-dashboard">

                        <span><strong>Notifications & Alerts</strong></span>
                    </div>
                </div>


            </div>


        </div>

    </div>
</div>

<div class="row mb-3">
    
    <div class="col-md-6">
        <span class="text-corporate-dark-color box_sessions_tag"><strong>Courses </strong></span>
    </div>
    
    <div class="col-md-3 border-bottom-inst text-center">
        <span class="box_sessions_tag"><strong>Notifications </strong></span>
    </div>
    
    <div class="col-md-3 border-bottom-inst text-center">
        <span class="box_sessions_tag"><strong>Email </strong></span>
    </div>

</div>


<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag ">1. Course creation confirmation</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-course-notification-1">

        <svg id="course-notification-1" class="cursor_pointer" onclick="changeBtnNotification('course-notification-1','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-course-email-1">
        <svg id="course-email-1" class="cursor_pointer" onclick="changeBtnNotification('course-email-1','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-5">
    
    <div class="col-md-6">
        <span class="box_sessions_tag ">2. Course coaching date changes</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-course-notification-2">

        <svg id="course-notification-2" class="cursor_pointer" onclick="changeBtnNotification('course-notification-2','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-course-email-2">
        <svg id="course-email-2" class="cursor_pointer" onclick="changeBtnNotification('course-email-2','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>


<div class="row mb-3">
    
    <div class="col-md-6">
        <span class="text-corporate-dark-color box_sessions_tag"><strong>Students </strong></span>
    </div>
    
    <div class="col-md-3">
        
    </div>
    
    <div class="col-md-3">
        
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">1. 50% of student enrollment</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-1">

        <svg id="student-notification-1" class="cursor_pointer" onclick="changeBtnNotification('student-notification-1','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-1">
        <svg id="student-email-1" class="cursor_pointer" onclick="changeBtnNotification('student-email-1','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">2. 75% of student enrollment</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-2">

        <svg id="student-notification-2" class="cursor_pointer" onclick="changeBtnNotification('student-notification-2','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-2">
        <svg id="student-email-2" class="cursor_pointer" onclick="changeBtnNotification('student-email-2','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">3. Weekly Attendance Report</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-3">

        <svg id="student-notification-3" class="cursor_pointer" onclick="changeBtnNotification('student-notification-3','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-3">
        <svg id="student-email-3" class="cursor_pointer" onclick="changeBtnNotification('student-email-3','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">4. Assignment uploading reminder</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-4">

        <svg id="student-notification-4" class="cursor_pointer" onclick="changeBtnNotification('student-notification-4','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-4">
        <svg id="student-email-4" class="cursor_pointer" onclick="changeBtnNotification('student-email-4','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">5. Student gradebook report</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-5">

        <svg id="student-notification-5" class="cursor_pointer" onclick="changeBtnNotification('student-notification-5','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-5">
        <svg id="student-email-5" class="cursor_pointer" onclick="changeBtnNotification('student-email-5','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">6. Changes in the service policies or regulations</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-6">

        <svg id="student-notification-6" class="cursor_pointer" onclick="changeBtnNotification('student-notification-6','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-6">
        <svg id="student-email-6" class="cursor_pointer" onclick="changeBtnNotification('student-email-6','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">7. IT system updates and maintenance schedules</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-7">

        <svg id="student-notification-7" class="cursor_pointer" onclick="changeBtnNotification('student-notification-7','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-7">
        <svg id="student-email-7" class="cursor_pointer" onclick="changeBtnNotification('student-email-7','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-2">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">8. Student accommodation requests and updates</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-8">

        <svg id="student-notification-8" class="cursor_pointer" onclick="changeBtnNotification('student-notification-8','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-8">
        <svg id="student-email-8" class="cursor_pointer" onclick="changeBtnNotification('student-email-8','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

<div class="row mb-3">
    
    <div class="col-md-6">
        <span class="box_sessions_tag">9. LinguaMeeting resources and services updates</span>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-notification-9">

        <svg id="student-notification-9" class="cursor_pointer" onclick="changeBtnNotification('student-notification-9','off')" xmlns="http://www.w3.org/2000/svg" fill="#186e74" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192s-86-192-192-192H192zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
    </div>
    
    <div class="col-md-3 text-center" id="div-student-email-9">
        <svg id="student-email-9" class="cursor_pointer" onclick="changeBtnNotification('student-email-9','on')" xmlns="http://www.w3.org/2000/svg" fill="#545454" height="1.8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128H192c-70.7 0-128-57.3-128-128s57.3-128 128-128H384zM576 256c0-106-86-192-192-192H192C86 64 0 150 0 256S86 448 192 448H384c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
    </div>

</div>

@endsection

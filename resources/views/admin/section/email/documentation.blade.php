@extends('layouts.app_mail')

@section('content')

    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 20px 0 20px 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <h3>Dear Professor</h3>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 5px 30px 5px 30px; color: #404040;  font-weight: 400; line-height: 25px;">
                        <br>
                        <div style="text-align:center; font-size:22px;"><strong>Your Courses Are Registered!</strong></div>
                        <br>
                        <div style="text-align:center;">Here you will find next steps and helpful resources for you and your students to ensure a smooth semester.</div>
                        <br>
                        <div style="text-align:center; font-size:18px;"><u>Next Steps:</u></div>
                        <ol>
                            <li>Confirm course information through your portal
                                <ul>
                                    <li><i><strong>New users:</strong> activate your account by clicking on the link sent to your email.</i></li>
                                </ul>
                            </li>
                            <li>Share registration instructions with students'
                                <ul>
                                    <li><i>Locate under Active Courses>Course Name>Sections/Attendance>Instructions.</i></li>
                                </ul>
                            </li>
                            <li>
                                Upload your course assignment/instructions, see our <a href="https://www.youtube.com/watch?v=jTTxZU_G_Lo">video tutorial</a> -<i><strong>New feature!</strong></i>
                                <ul>
                                    <li>
                                        <i><strong>**IMPORTANT: </strong>Specific assignments should be clarified for each week pertaining to your course objectives. Starting this semester, we will not
                                            work with textbooks or syllabi: this way, our coaches will have more precise session content instructions.
                                        </i>
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 5px 30px 5px 30px; color: #404040;  font-weight: 400; line-height: 25px;">

                        <div style="text-align:center; font-size:18px;">
                            <strong>A list of useful faculty and student resources are included below:</strong>
                        </div>
                        <p>
                            <strong>Resources for Faculty and Students</strong></p>
                        <ol>
                            <li><a href="https://docs.google.com/document/d/1FFhjnPuz2tDUT-aWeBMkoodqnrCnFulFkKqy-4J5H0U/edit">Faculty Start-Up</a></li>
                            <li><a href="https://docs.google.com/document/d/1dTavaMUu2Oet_mpFNtqR08McF3trIEbnvFkQQyTeG6A/edit">Student Start-Up</a></li>
                            <li><a href="https://www.dropbox.com/sh/nsm6c4gt35wtgj3/AADgxGur33W9wos5xH7eeMSra?dl=0">Sample Assignments and Template</a></li>
                            <li><a href="https://drive.google.com/drive/folders/1Z6PK6JKZzSVnQC_7NUaVr5HnZ35aN0yI">LinguaMeeting Description, Syllabus Attachment</a></li>
                            <li><a href="https://www.dropbox.com/s/tudu0fu1oya81a5/LinguaMeeting_Manual_Faculty.pdf?dl=0">
                                    <span style="color:red;">New</span>Instructor’s guide for a Successful implementation</a>
                            </li>
                            <li><a href="https://drive.google.com/drive/folders/11n5JOp6tS_Ue7GMBJ1ck__02WChFab4K">LinguaMeeting Conversation Guides </a></li>
                            <li><a href="https://drive.google.com/file/d/18mA3WfZrDMwjqp_F8adNcUILrjcYuHJd/view">First day of class presentation</a></li>
                        </ol>

                        <p><strong>Video Tutorials for Faculty</strong></p>
                        <ol>
                            <li><a href="https://youtu.be/d6Nmnr_dIlM">Coaching Form Tutorial</a></li>
                            <li><a href="https://www.youtube.com/watch?v=jTTxZU_G_Lo">Upload Course Assignment</a></li>
                            <li><a href="https://www.youtube.com/watch?v=x6mux-OYxBw">Faculty portal</a></li>
                            <li><a href="https://www.youtube.com/playlist?list=PLVDUpAlOiVM3BsDvQE3SyohGPinl8y3eG">More</a></li>
                        </ol>

                        <p><strong>Video Tutorials for Students</strong></p>
                        <ol>
                            <li><a href="https://www.youtube.com/watch?v=ExRsQ7bGLzY">First Day of Class Presentation</a></li>
                            <li><a href="https://www.youtube.com/watch?v=yXNeD6i4JU4">Getting Started: LinguaMeeting Registration and Tour </a></li>
                            <li><a href="https://www.youtube.com/watch?v=YswdMDr54Mo">How to Reschedule a Session</a></li>
                        </ol>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 5px 30px 5px 30px; color: #404040;  font-weight: 400; line-height: 25px;">

                        @if ($section->course->isLingro())
                            <p><strong>Looking forward to working again with you!</strong></p>
                        @else
                            <p style="text-align:left; ">Please feel free to reach out to our team at <a href="mailto:support@linguameeting.com">support@linguameeting.com</a> or directly back to this email if any questions may
                                arise. Also, if new faculty members at your school are interested in joining LinguaMeeting, let us know to schedule a demo.</p>
                            <br>If you have any questions, please email <a href="mailto:support@linguameeting.com">support@linguameeting.com</a>.

                            <p style="text-align:left; ">Thank you and welcome to our community!</p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>




@endsection


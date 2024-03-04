@extends('layouts.app_mail')

@section('content')

    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 20px 0 20px 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">


                        <h3>Dear {{$user->name}}</h3>

                        <p>We have received your LinguaMeeting Coaching Form! Thank you for taking the time to register your courses for the semester.</p>

                        <p style="color:#35b4b4;"><strong>What's Next?</strong></p>
                        <p>Please share the instructions with students in order for them to register for the LinguaMeeting course. Find attached:</p>
                        <ol>
                            <li>A PDF summary of your course/section and,</li>
                            <li>Student instructions.</li>
                        </ol>
                        <p>These documents are also available to view through your Instructors' Portal.</p>




                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 5px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="color:#35b4b4;margin-top:0"><strong>Need to add/edit a course?</strong></p>
                        <ol>
                            <li>Enter the portal <a href="#">here</a>.</li>
                            <li>Click <span style="font-style: italic">Menu</span> >
                                <span style="font-style: italic">Tab</span> >
                                <span style="font-style: italic">Coaching Form</span> >
                                <span style="font-style: italic">Select University/School</span>
                            </li>
                            <li>Select "<span style="font-style: italic">Create New Course/Edit an existing course</span>".</li>
                        </ol>
                        <br>If you have any questions, please email <a href="mailto:support@linguameeting.com">support@linguameeting.com</a>.

                        <p>Thank you and welcome to our community!</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>




@endsection


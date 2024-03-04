@extends('layouts.app_mail')

@section('content')

    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 20px 0 20px 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">

                        <p>Welcome to Experiences!</p>

                        <p>
                            This is an email confirmation for your Experience: <strong>{{$experienceRegister->experience->title}}</strong> on
                            <strong>{{ $experienceRegister->experience->startTime(userTimezoneName())->format('l jS F Y - g:ia')  }}</strong>.
                        </p>
                        <p>
                            Enjoy it!
                        </p>
                        <p>
                            If you wish to contact us, please do not reply to this message but instead contact support:
                            <a href="mailto:support@linguameeting.com">support@linguameeting.com</a>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">

                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection

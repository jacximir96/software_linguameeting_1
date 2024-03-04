@extends('layouts.app_mail')

@section('content')

    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 20px 0 20px 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <h3>Dear {{$name}}</h3>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">
                        Welcome to LinguaMeeting
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 5px 30px; color: #404040; font-size: 18px; font-weight: 400; line-height: 25px;">
                        Please click in <a href="{{route('login')}}">LINGUAMEETING</a> to enter in LinguaMeeting and view your sessions.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection

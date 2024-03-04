<div style="padding:0;width: 100%;">
    <table border="0" align="left" class=" w-100" cellpadding="0" cellspacing="0">
        <tr>
            <td class="" align="left">
                <img src="{{asset('assets/img/logo_anagrama.png')}}" width="150px">
                <hr>
            </td>
        </tr>
    </table>
</div>

<div style="padding:0;width: 100%;">
    <table border="0" align="left" class=" w-100" cellpadding="0" cellspacing="0" style="color:#35B4B4;">

        <tr style="">
            <td class="p-3" align="left">
                    <span style="font-size:17px;">Linguameeting Live Language Coaching Student Information Sheet</span>
                    <br><br>

                    <span style="font-size:12px;font-weight: bold;">
                        {{$request->conversationPackage->name}} -  {{$request->conversationPackage->duration_session}}
                        <br>
                        ISBN: {{$request->isbn}}
                    </span>
            </td>
        </tr>
        <tr style="">
            <td class="p-3" align="left">

            </td>
        </tr>
    </table>
</div>

<div style="margin-top:1cm;padding:0;width: 100%;">
    <table border="0" align="left" class=" w-100" cellpadding="0" cellspacing="0" style="color:#000;">

        <tr style="">
            <td class="p-3" align="left">
                <span style="font-size:14px;">Congratulations!</span>
            </td>
        </tr>
        <tr style="">
            <td class="p-3" align="left" style="font-size:14px;">
                    <span >
                        You have signed up for a great opportunity to develop and practice your conversational skills. During the semester, you will engage in 30/15-minute online group/individual
                        coaching sessions with a native-speaking language coach. The coach will help you reinforce what you have learned in class and encourage you to participate in each
                        conversation, in Spanish. Here's some additional information about the LinguaMeeting experience:
                    </span>
            </td>
        </tr>

    </table>d
</div>

<div style="margin-top:1cm; padding:0;width: 100%;">
    <table border="0" align="left" class=" w-100" cellpadding="0" cellspacing="0" style="color:#000;">

        <tr style="">
            <td class="p-3" align="left" style="font-size:14px;">
                <span >How do I get started?</span>

                <ul>
                    <li>1. Go to <a href="http://develop.linguameeting.com/register" target="_blank>" style="color:blue">{{route('register')}}</a></li>
                    <li>2. Enter the Class ID.</li>
                    <li>3. Create a user name, password and ENTER THE LINGUAMEETING CODE.</li>
                    <li>4. After you will be prompted to choose from the available session times.
                        Your session will always be on the same day of the week and at the same
                        time of day unless you change it.</li>
                </ul>
            </td>
        </tr>
    </table>
</div>

<div style="margin-top:1cm; padding:0;width: 100%;">
    <table border="0" align="left" class=" w-100" cellpadding="0" cellspacing="0" style="color:#000;">


        <tr style="">
            <td class="p-3" align="left" style="font-size:14px;">
                <span >
                    Contact Support at <a href="http://develop.linguameeting.com/support" target="_blank>" style="color:blue">http://develop.linguameeting.com/support</a>
                </span>
            </td>
        </tr>
    </table>
</div>

<div style="margin-top:1cm; padding:0;width: 100%;">
    <table border="0" align="left" class=" w-100" cellpadding="0" cellspacing="0" style="color:#000;font-size:25px;">

        <tr style="">
            <td class="p-3" align="left">
                <span style="color:#35B4B4">LINGUAMEETING CODE:</span>
                <br><br>
                <span style="color:#000">{{$code->code}}</span>
            </td>
        </tr>
    </table>
</div>

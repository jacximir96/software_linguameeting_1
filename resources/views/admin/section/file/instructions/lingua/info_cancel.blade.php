@include('admin.section.file.instructions.title_section', ['title' => 'Booking, Rescheduling, Canceling and Making-Up Sessions'])

<table border="0" align="left" class="w-100 table-instructions" style="{{isset($marginTopZero) ? 'margin-top: 0.2cm' : ''}}" cellpadding="0" cellspacing="0">

    <tr>
        <td>
            <p class="text-deep-black p-info mb-5">
                <ul class="mt-5">
                    <li class="text-deep-black p-info ">
                        <span class="bold">Book a session:</span> Students may book a session up to 12 hours prior to a session start time.
                    </li>
                    <li class="text-deep-black p-info ">
                        <span class="bold">Cancel/reschedule a session:</span>
                        Students may cancel or reschedule their session up to 5
                        hours prior to their session start time. To reschedule, students must select a session
                        at least 12 hours in advance of the new desired session time.
                    </li>
                    @if ($viewData->hasBuyMakeups())
                        <li class="text-deep-black p-info ">
                            <span class="bold">Make-Up a session:</span>
                            Your instructor may grant one or more make-up sessions for
                            purchase, which should be completed prior to the LinguaMeeting course end date.
                        </li>
                    @endif
                </ul>
            </p>
        </td>
    </tr>

</table>

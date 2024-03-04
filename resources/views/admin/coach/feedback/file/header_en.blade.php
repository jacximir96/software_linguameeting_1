<h5 class="text-corporate-dark-color section-title bold mb-10">COACH FEEDBACK</h5>

<table border="0" align="left" cellpadding="1" cellspacing="0" width="100%">
    <tr>
        <td align="left" class="w-50" width="30%">
            <p class="p-info mb-10">
                <span class="text-corporate-dark-color bold">Name</span>
                <br>
                {{$wrapper->get()->coach->writeFullName()}}
            </p>
        </td>
        <td width="30%">
            <p  class="p-info mb-10">
                <span class="text-corporate-dark-color bold">Language</span>
                <br>
                {{$wrapper->language()->name}}
            </p>
        </td>
        <td width="30%">
            <p  class="p-info mb-10">
                <span class="text-corporate-dark-color bold">Date</span>
                <br>
                {{$wrapper->printMoment()}}
            </p>
        </td>
    </tr>

    <tr>


        <td colspan="3">
            <p  class="p-info">
                <span class="text-corporate-dark-color bold">Recording</span>
                @if ($wrapper->hasRecordingUrl())
                    <a href="{{$wrapper->get()->recording_url}}" target="_blank" title="Show recording" >
                        {{$wrapper->get()->recording_url}}
                    </a>
                @else
                    -
                @endif
            </p>
        </td>
    </tr>

</table>

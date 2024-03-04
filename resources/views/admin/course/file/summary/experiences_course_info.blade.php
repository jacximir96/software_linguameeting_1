<table border="0" align="left" class=" w-100  mt-20"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" class="text-corporate-dark-color section-title">
            Course: {{$viewData->course()->name}}
        </td>
    </tr>
    @php $conversationPackage = $courseSummary->course()->conversationPackage; @endphp
    <tr>
        <td align="left">
            <p class="text-deep-black p-info">
                <span class="">University course dates:</span> <span>{{$courseSummary->startDate()->format('M dS')}} to {{$courseSummary->endDate()->format('M dS')}}</span>.
            </p>
        </td>
    </tr>

    <tr>
        <td align="left">
            <p class="text-deep-black p-info">
                <span class="">Experiences:</span>
                <span>{{$courseSummary->course()->experienceType->write()}} -
                {{$linguaMoney->format($courseSummary->course()->price())}}
            </span>.
            </p>
        </td>
    </tr>

</table>

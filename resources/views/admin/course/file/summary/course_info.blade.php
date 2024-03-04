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
                <span class="">Number of session:</span> <span>{{$conversationPackage->number_session}} sessions of {{$conversationPackage->duration_session}} minutes</span>.
            </p>
        </td>
    </tr>
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
                <span class="">Package type:</span>
                <span>{{$courseSummary->course()->conversationPackage->name}} -
                {{$linguaMoney->format($courseSummary->course()->price())}}
            </span> -
                <span>{{$courseSummary->course()->conversationPackage->isbn}}</span>.
            </p>
        </td>
    </tr>
    @if ($courseSummary->course()->conversationGuide->hasBook())
        <tr>
            <td align="left">
                <p class="text-deep-black p-info">
                    <span class="">Conversation Guides:</span>
                    <span>{{$courseSummary->course()->conversationGuide->nameWithLanguage()}}</span>.
                </p>
            </td>
        </tr>
    @endif
    <tr>
        <td  align="left">
            <p class="text-deep-black p-info">
                <span class="">Make-up sessions for purchase:</span> <span>{{$viewData->hasBuyMakeups() ? $viewData->printBuyMakeups() : 'None'}}</span>.
            </p>
        </td>
    </tr>

    @if ($courseSummary->course()->complimmentary_makeup)

        <tr>
            <td align="left">
                <p class="text-deep-black p-info">
                    <span class="">Complimentary make-ups received:</span> <span>1</span>.
                </p>
            </td>
        </tr>

    @endif
</table>

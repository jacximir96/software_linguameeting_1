<table border="0" align="left" class="w-100 mt-10"  cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <p class="text-deep-black p-info">
                <span class="bold">Course: </span> <span class="bold">{{$viewData->course()->university->name}}</span>
            </p>
        </td>
    </tr>
     <tr>
         <td align="left">
             <p class="text-deep-black p-info">
                    <span class="">Class:</span> <span >{{$viewData->section()->name}}</span>.
             </p>
        </td>
    </tr>

    @if ($viewData->isFlex())
         <tr>
             <td align="left">
                 <p class="text-deep-black p-info">
                    <span class="">LinguaMeeting sessions</span> <span >Start {{$viewData->period()->getStartDate()->format('m/d/Y')}}</span>
                 </p>
            </td>
        </tr>
    @else
         <tr>
             <td align="left">
                 <p class="text-deep-black p-info">
                    <span class="">LinguaMeeting Sessions:</span>
                    <span >{{$viewData->period()->start_date->format('m/d/Y')}}</span> to
                    <span >{{$viewData->period()->end_date->format('m/d/Y')}}</span>.
                 </p>
            </td>
        </tr>

    @endif

     <tr>
         <td align="left">
             <p class="text-deep-black p-info">
                <span class="" style="font-size:11px">*Class ID:</span> Not needed when registering from LingroHub ({{$viewData->section()->code}}).
             </p>
        </td>
    </tr>

</table>

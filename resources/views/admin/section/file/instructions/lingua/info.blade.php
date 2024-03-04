<table border="0" align="left" class=" w-100 mt-10" cellpadding="0" cellspacing="0">

    <tr>
        <td align="left">
            <p class="text-deep-black p-info">
            <span class="bold">Course:</span>
                <span >{{$viewData->section()->course->name}} </span> -
                <span  class="text-corporate-color">Class ID:</span>
                <span  class="text-corporate-color">{{$viewData->section()->code}}</span>.
            </p>
        </td>
    </tr>
     <tr>
         <td align="left">
             <p class="text-deep-black p-info">
                <span class="bold">Class:</span> <span >{{$viewData->section()->name}}</span>.
             </p>
        </td>
    </tr>
     <tr>
         <td align="left">
             <p class="text-deep-black p-info">
                <span class="bold">Class URL:</span> <a href="#"  class="text-corporate-color">https://linguameeting.com/instructions-...TODO</a>.
             </p>
        </td>
    </tr>

    @if ($viewData->isFlex())
         <tr>
             <td align="left">
                 <p class="text-deep-black p-info">
                    <span class="bold">LinguaMeeting Sessions</span> <span >Start {{$viewData->period()->getStartDate()->format('m/d/Y')}}</span>
                 </p>
            </td>
        </tr>
    @else
         <tr>
             <td align="left">
                 <p class="text-deep-black p-info">
                    <span class="bold">LinguaMeeting sessions:</span>
                    <span >{{$viewData->period()->start_date->format('m/d/Y')}}</span> to
                    <span >{{$viewData->period()->end_date->format('m/d/Y')}}</span>.
                 </p>
            </td>
        </tr>
    @endif

</table>

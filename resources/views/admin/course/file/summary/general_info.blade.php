<table border="0" align="left" class="w-100 mt-20 " cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" class="text-corporate-dark-color section-title">
            General Information
        </td>
    </tr>
    <tr>
        <td align="left">
            <p class="text-deep-black p-info">
                <span class="">School: </span><span>{{$viewData->course()->university->name}}</span>
            </p>
            <p class="text-deep-black p-info">
                <span class="">Time Zone: </span><span>{{$viewData->course()->university->timezone->name}}</span>
            </p>
            <p class="text-deep-black p-info">
                <span class="">Holidays: </span>

                @if ($viewData->hasHolidays())
                    @foreach ($viewData->holidays() as $holiday)
                        <span>{{$holiday->format('M dS')}}</span>@if ( ($viewData->holidays()->count()>1) AND (!$loop->last))<span style="margin-left:5px;margin-right:5px">/</span> @endif
                    @endforeach
                @else
                    No holidays
                @endif
            </p>
            @if ($viewData->course()->hasFree())
                <p class="text-deep-black p-info">
                    <span class="">Open Access: </span>
                    @if ($viewData->course()->isFree())
                        <span class="">{{$viewData->course()->isFree() ? 'Yes' : ''}}</span>
                    @endif

                    @if (!$viewData->course()->isFree() AND $viewData->course()->hasSectionFree())
                        <span class="">Only for: </span>
                        <ul>
                            @foreach ($viewData->course()->section as $section)
                                @if ($section->isFree())
                                    <li>{{$section->name}}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </p>
            @endif

            @if($viewData->course()->hasDiscount())
                <p class="text-deep-black p-info">
                    <span class="">Discount: </span>
                    <span class="fst-italic">{{$linguaMoney->format($courseSummary->course()->discount)}}</span>
                </p>
            @endif
        </td>
    </tr>
</table>

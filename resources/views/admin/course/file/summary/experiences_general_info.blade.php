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

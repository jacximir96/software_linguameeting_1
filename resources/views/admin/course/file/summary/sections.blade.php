<table border="0" align="left" class=" w-100 mt-20" cellpadding="0" cellspacing="0">

    <tr>
        <td align="left" class="text-corporate-dark-color section-title">
            <p class="" style="">Sections</p>
        </td>
    </tr>
    <tr>
        <td>
            @foreach ($courseSummary->course()->section as $section)

                <p class="text-deep-black p-info">
                    @if ($courseSummary->course()->section->count() == 1)
                        Class/Section:{{$section->name}} - Class ID: {{$section->code}}
                    @else
                        Class/Section {{$loop->iteration}}:{{$section->name}} - Class ID: {{$section->code}}
                    @endif
                </p>

                <p class="text-deep-black p-info " style="margin-bottom:20px;">
                    Instructor: {{$section->instructor->name}} {{$section->instructor->lastname}}
                </p>
            @endforeach
        </td>
    </tr>

</table>

<div class="table-container">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th class="text-center" style="width: 9%">Hora</th>
                @for ($i = 0; $i < 7; $i++)
                    <th style="width: 13%">
                        {{ $startOfWeek->copy()->addDays($i)->toDateString() }}
                        <br>
                        {{ ucfirst($startOfWeek->copy()->addDays($i)->locale('en')->translatedFormat('l')) }}
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody>    
            <tr>
                <td colspan="8"></td>
            </tr>
            @for ($hour = 8; $hour <= 21; $hour++)
                @for ($minute = 0; $minute < 60; $minute += 30)
                    <tr style="height: 50px">
                        <td>
                            {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($minute, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        @for ($day = 0; $day < 7; $day++)
                            <td style="text-align: center;">
                                @foreach ($days as $session)
                                    @php
                                        $sessionDateTime = Carbon\Carbon::parse($session['day'] . ' ' . $session['start_time']);
                                        $currentDateTime = $startOfWeek->copy()->addDays($day)->setHour($hour)->setMinute($minute);
                                    @endphp
                                    @if ($currentDateTime->eq($sessionDateTime))
                                        
                                        @include('instructor.course.schedule.sessions_by_day')
                                        
                                    @endif
                                @endforeach
                            </td>
                        @endfor
                    </tr>
                    @if (($minute == 30 || $minute == 0) && $hour <= 21)
                        <tr>
                            <td colspan="8"><hr></td>
                        </tr>
                    @endif
                @endfor
            @endfor
        </tbody>
    </table>
</div>    


@if ($students->count())
    <table id="table-gradebook" class="table border">
        <thead>
        <tr class="">
            <th class="">STUDENT</th>
            @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)
                <th class="text-center text-corporate-dark-color custom-color-background-instructor">S{{$numberSession}}</th>
            @endfor
        </tr>
        </thead>

        <tbody>

        @foreach ($students as $student)
            <tr class="">
                <td class="">
                    {{$student->student()->writeFullNameAndLastName()}}
                </td>
                @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)

                    @if ($student->applyForSession($numberSession))
                        <td class="text-center ">
                            {{$student->gradeInSession($numberSession)->get()}}
                        </td>
                    @else
                        <td class="bg-gray" style="background-color: #ccc">

                        </td>
                    @endif

                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

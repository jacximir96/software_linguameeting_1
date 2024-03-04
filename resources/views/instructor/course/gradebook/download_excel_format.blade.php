@if ($students->count())
    <table id="table-gradebook" class="table border" data-paging="false" data-searching="false" data-ordering="false" style="table-display:fixed">
        <thead>
        <tr >
            <th  style="background-color: #fff; color:#aaaaaa; width: 200px;">STUDENT</th>
            <th  style="background-color: #fff; color:#aaaaaa; width: 140px; text-align: center;">SESS. COMPLETED</th>
            @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)
                <th
                    style="background-color: #eef5f3; color:#186e74; text-align: center; width: 100px">
                    SESSION {{$numberSession}}
                </th>
            @endfor
            <th  style="background-color: #186e74; color:#FFF !important; width: 140px;">FEEDBACK SUM</th>
        </tr>
        </thead>

        <tbody>

        @forelse ($students as $student)
            <tr >
                <td >
                    {{$student->student()->writeFullNameAndLastName()}}
                </td>
                <td style="text-align: center;">
                    {{$student->countReviews()}}
                </td>
                @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)

                    @if ($student->applyForSession($numberSession))
                        <td style="text-align: center;">
                            {{$student->gradeInSession($numberSession)->get()}}
                        </td>
                    @else
                        <td style="background-color: #ccc">

                        </td>
                    @endif

                @endfor

                <td style="background-color: #cdebcc; color:#186e74; text-align: center;">
                    {{$student->totalGrade()->get()}}
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="" class="text-center bg-warning-soft fw-bold">
                    No Students Found
                </td>
                <td></td><td></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endif

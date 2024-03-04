@if ($students->count())
<table id="table-gradebook" class="table border" data-paging="false" data-searching="false" data-ordering="false" style="table-display:fixed">
    <thead>
        <tr class="">
            <th class="">STUDENT</th>
            <th class="text-center">SESS. COMPLETED</th>
            @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)
                <th class="text-center text-corporate-dark-color custom-color-background-instructor">SESSION {{$numberSession}}</th>
            @endfor
            <th class=" bg-corporate-dark-color text-white text-center">FEEDBACK SUM</th>
        </tr>
    </thead>

    <tbody>

        @forelse ($students as $student)
            <tr class="">
                <td class="">
                    <a class="text-corporate-color" href="{{route('get.instructor.students.show', $student->enrollment()->hashId())}}">
                        <u>{{$student->student()->writeFullNameAndLastName()}}</u>
                    </a>
                </td>
                <td class="text-center">
                    {{$student->countReviews()}}
                </td>
                @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)

                    @if ($student->applyForSession($numberSession))
                        <td class="text-center text-corporate-dark-color custom-color-background-instructor">
                            {{$student->gradeInSession($numberSession)->get()}}
                        </td>
                    @else
                        <td class="bg-gray" style="background-color: #ccc">

                        </td>
                    @endif

                @endfor

                <td class="text-center text-corporate-dark-color bg-feedback-good">
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
@else
    <div class="row">
        <div class="col-12 alert text-center fw-bold alert-warning">
            Students not found. Change filter.
        </div>
    </div>

@endif

<script>

    jQuery(document).ready(function () {

        jQuery.ajaxSetup({cache: false});

        new DataTable('#table-gradebook', {
            fixedColumns: {
                left: 2,
                right: 1
            },
            /*"autoWidth": false,*/ /* comentado porque da error con bootstrap */
            scrollCollapse: true,
            scrollX: true,
            scrollY: 300,
            "columnDefs": [
                { "width": "200px", "targets": 0 },
                { "width": "130px", "targets": 1 },
                @for ($numberSession = 1; $numberSession <= $maxSessions; $numberSession++)
                { "width": "100px", "targets": {{$numberSession}} },
                @endfor
                    @php $numberSession++ @endphp
                { "width": "130px", "targets": {{($numberSession)}} },
            ],
            "paging":   false,
            "ordering": false,
            "info":     false
        });
    });
</script>

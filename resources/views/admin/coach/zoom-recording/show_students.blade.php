<div class="card">
    <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="m-0 font-weight-bold"><i class="fa fa-users"></i> Students</span>
    </div>
    <div class="card-body padding-05-rem">

        @if ($recording->session)
        <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
            <thead>
            <tr>
                <th class="w-30">Student</th>
                <th>Section</th>
                <th>Course</th>
                <th>University</th>

            </tr>
            </thead>

            <tbody>

                @foreach ($recording->session->enrollmentSession as $enrollmentSession)
                    @php $student = $enrollmentSession->enrollment @endphp
                    <tr>
                        <td>{{$student->user->writeFullName()}}</td>
                        <td>{{$student->section->name}}</td>
                        <td>
                            <a href="{{route('get.admin.course.show', $student->section->course->id)}}"
                               title="Show Course"
                               target="_blank">
                                {{$student->section->course->name}}
                            </a>
                        </td>
                        <td>
                            {{$student->section->course->university->name}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @else
                <p class="text-danger">
                    The recording does not have an associated session.
                </p>

            @endif
        </table>
    </div>
</div>

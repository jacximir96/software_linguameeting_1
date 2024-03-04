<table>
    <thead>
        <tr>
            <th colspan="6">List of Students</th>
        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th><strong>Last Name</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>University</strong></th>
            <th><strong>Course</strong></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6"></td>
    </tr>
    @forelse ($students as $student)
        <tr>
            <td>{{$student->lastname}}</td>
            <td>
                {{$student->name}}

                @if ( ! $student->isActive())
                    (Disabled)
                @endif

                @if ( $student->isDeleted()!='')
                    (Deleted)
                @endif
            </td>
            <td>{{$student->email}}</td>
            <td>
                @if ($student->enrollment->count())
                    {{ $student->enrollment->first()->section->course->university->name }}
                @else
                    -
                @endif
            </td>
            <td>
                @if ($student->enrollment->count())
                    {{ $student->enrollment->first()->section->course->name }}
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">
                Students not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="11">List of courses</th>
        </tr>
        <tr>
            <th colspan="11"></th>
        </tr>
        <tr>
            <th>ID</th>
            <th>University</th>
            <th>Name</th>
            <th>Lingro</th>
            <th>Period</th>
            <th>Year</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Registered</th>
            <th>X Session</th>
            <th>Created</th>

        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="11"></td>
    </tr>
    @forelse ($courses as $course)

        <tr>
            <td>{{$course->id}}</td>
            <td>{{$course->university->name}}</td>
            <td>{{$course->name}}</td>
            <td>{{ $course->isLingro() ? 'Yes' : 'No' }}</td>
            <td>{{$course->semester->name}}</td>
            <td>{{$course->year}}</td>
            <td>{{$course->start_date->toFormattedDayDateString()}}</td>
            <td>{{$course->end_date->toFormattedDayDateString()}}</td>
            <td>reg.</td>
            <td>sess</td>
            <td>{{$course->created_at->toFormattedDayDateString()}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="12">
               Courses not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

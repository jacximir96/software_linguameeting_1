<table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
    <thead>
    <tr class="small">
        <th>Name</th>
        <th>Date</th>
        <th>¿Lingro?</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($viewData->courses() as $course)
        <tr class="s">
            <td>
                <a href="{{route('get.admin.course.show', $course->id)}}" class="" title="Show detail course">
                    {{$course->name}}
                </a>
            </td>
            <td>{{toDate($course->start_date)}} <span class="fst-italic">to</span> {{toDate($course->end_date)}}</td>
            <td>{{$course->isLingro() ? 'Yes' : 'No'}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2">No active courses</td>
        </tr>
    @endforelse
    </tbody>
</table>

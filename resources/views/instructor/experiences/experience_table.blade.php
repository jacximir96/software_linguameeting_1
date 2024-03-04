<table id="table-instructor" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false" border="1">
    <thead>
    <tr>
        <th class="">EXPERIENCE</th>
        <th class="">DATE</th>
        <th>RECORDING</th>
        <th>COACH</th>
        <th>STUDENTS</th>
    </tr>
    </thead>

    <tbody>

    @forelse ($experiences as $itemExperience)
        <tr>
            <td class="text-corporate-color">
                <a href="{{route('get.instructor.experiences.show', $itemExperience->experience()->id)}}"
                   class="open-modal "
                   data-modal-size="modal-lg"
                   data-modal-reload="no"
                   data-modal-height="h-95"
                   data-modal-title="Show Students">
                    <u>{{$itemExperience->experience()->title}}</u>
                </a>

            </td>
            <td class="">
                <u>{{toDayDateTimeString($itemExperience->experience()->start, $experienceTimezone)}}</u>
            </td>
            <td>
                @if ($itemExperience->experience()->hasRecording())
                    <a href="{{$itemExperience->experience()->zoom_video}}" class="" target="_blank">
                        <i class="fa fa-video"></i>
                    </a>
                @else
                    <a href="#" class="text-muted" target="_blank">
                        <i class="fa fa-video"></i>
                    </a>
                @endif
            </td>
            <td>{{$itemExperience->experience()->coach->writeFullNameAndLastName()}}</td>

            <td>
                <a href="{{route('get.instructor.experiences.show', $itemExperience->experience()->id)}}"
                   class="open-modal text-decoration-none "
                   data-modal-size="modal-lg"
                   data-modal-reload="no"
                   data-modal-height="h-95"
                   data-modal-title="Show Students">
                    <u>{{$itemExperience->numStudents()}}</u>
                </a>

            </td>

        </tr>
    @empty
        <tr>
            <td colspan="4">No hay experiencias para mostrar.</td>
        </tr>

    @endforelse

    </tbody>
</table>

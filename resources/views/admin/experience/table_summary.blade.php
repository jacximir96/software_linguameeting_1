<table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
    <thead>
    <tr class="small">
        <th>Recording</th>
        <th class="w-30">Title</th>
        <th>Day</th>
        <th>Time<br>Start (EST)</th>
        <th>Time<br>End (EST)</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($experiences->sortByDesc('id') as $experience)
        <tr class="s">
            <td>
                @if ($experience->hasRecording())
                    <a href="{{$experience->zoom_video}}" target="_blank" title="Show Vídeo">
                        <i class="fa fa-video"></i>
                    </a>
                @else
                    -
                @endif
            </td>
            <td>
                <span class="d-block">{{$experience->title}}</span>
            </td>
            <td>
                {{toDate($experience->start)}}
            </td>
            <td>
                {{toTime24h($experience->start, $experienceTimezone->name)}}
            </td>
            <td>
                {{toTime24h($experience->end, $experienceTimezone->name)}}
            </td>
            <td>
                <a href="{{route('get.admin.experience.edit', $experience->id)}}" class="text-primary me-3" title="Edit Experience">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No experience found</td>
        </tr>
    @endforelse
    </tbody>
</table>

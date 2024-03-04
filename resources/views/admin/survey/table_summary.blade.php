<table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
    <thead>
    <tr class="small">
        <th class="w-50">Description</th>
        <th>Date</th>
        <th>Active</th>
        <th>Observations</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    @forelse ($surveys as $survey)
        <tr class="s">
            <td>
                <span class="d-block">{{$survey->description}}</span>
                <a href="{{$survey->url}}" title="Go to survey" target="_blank" class="d-block">
                    {{$survey->url}}
                </a>
            </td>
            <td>{{toDate($survey->created_at)}}</td>
            <td>
                @if ($survey->isActive())
                    <span class="text-success">Yes</span>
                @else
                    <span class="text-danger">No</span>
                @endif
            </td>
            <td>
                @if ($survey->hasObservations())
                    <a href="{{route('get.admin.survey.show', $survey->id)}}"
                       class="open-modal me-2"
                       data-modal-size="modal-lg"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title='Show Survey'
                       title="Show Observations">
                        <i class="fa fa-comments text-primary"></i>
                    </a>
                @else
                    -
                @endif
            </td>
            <td>
                @include('admin.survey.actions', ['survey' => $survey])
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No survey found</td>
        </tr>
    @endforelse
    </tbody>
</table>

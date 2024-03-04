<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-video me-1"></i>
            Recordings
        </span>
    </div>
    <div class="card-body">
        <div class="row d-none d-sm-block">
            <div class="col-12">

                <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                    <thead>
                    <tr class="small">
                        <th>Start</th>
                        <th>End</th>
                        <th>Show</th>
                        <th>Download</th>
                        <th>Status</th>
                        <th class="w-5">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php $date = null @endphp
                    @forelse ($recordings as $recording)

                        @if ($date != $recording->start->todateString())
                            @php $date = $recording->start->toDateString() @endphp
                            <tr>
                                <td colspan="6" class="fw-bold bg-corporate-color-light">{{toDate($recording->start)}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <span class="d-block-inline">{{toDate($recording->start)}}</span> -
                                <span class="d-block-inline">{{toTimeHms($recording->start)}}</span>

                            </td>
                            <td>
                                <span class="d-block-inline">{{toDate($recording->end)}}</span> -
                                <span class="d-block-inline">{{toTimeHms($recording->end)}}</span>

                            </td>
                            <td class="text-left">
                                <a href="{{$recording->play_url}}" target="_blank">
                                    <i class="fa fa-play"></i>
                                </a>
                            </td>
                            <td class="text-left">
                                <a href="{{$recording->download_url}}" target="_blank">
                                    <i class="fa fa-download"></i>
                                </a>
                            </td>
                           <td class="text-left">
                               @if ($recording->isCompleted())
                                    <span class="text-success badge bg-success text-white">Completed</span>
                               @else
                                   {{$recording->status}}
                               @endif
                           </td>
                            <td>
                                <a href="{{route('get.admin.zoom.zoom_recording.coach.show', $recording->id)}}"
                                   title="Show Recording"
                                   class="open-modal d-block text-primary fw-bold"
                                    data-modal-size="modal-xl"
                                   data-modal-reload="no"
                                   data-modal-title='Show Recording'>
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="3">
                                <span class=" text-white bg-warning px-2 py-1 rounded ">No recordings registered</span>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row d-block d-sm-none">

            <div class="col-12">
                @if ($recordings->count())
                    <ul>
                        @foreach ($recordings as $item)
                            <li>
                                <span class="d-block">{{toDate($item->start)}}</span>

                                <span class="d-block mt-1 fst-italic">
                                    {{toDate($recording->start)}}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class=" text-white bg-warning px-2 py-1 rounded ">No recordings registered</span>
                @endif
            </div>

        </div>

        @if ($recordings->count())
            <a href="{{route('get.admin.zoom.zoom_recording.coach.show_all', $coach)}}"
               class="open-modal d-block mt-1 text-primary float-end"
               data-modal-size="modal-xl"
               data-modal-reload="no"
               data-reload-type="parent"
               data-modal-title="Show recordings of: {{$coach->writeFullName()}}">
                <i class="fa fa-list"></i> Show all
            </a>
        @endif
    </div>
</div>

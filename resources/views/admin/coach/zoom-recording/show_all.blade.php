@extends('layouts.app_modal')

@section('content')

    <div class="row">


        <div class="col-12 table-responsive">
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
            {{$recordings->render()}}
        </div>
    </div>

@endsection

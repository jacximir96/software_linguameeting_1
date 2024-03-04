@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-video me-1"></i>
                List of zoom meetings
            </span>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 mb-3 border-bottom">
                    <a href="{{ route('get.admin.coach.zoom.meeting.excel.download') }}"
                       class="small me-3"
                       title="Download Excel">
                        <i class="fa fa-download small-font-size-08"></i> Download Excel
                    </a>

                    <a href="{{ route('get.admin.coach.zoom.meeting.pdf.download') }}"
                       class="small"
                       title="Download PDF">
                        <i class="fa fa-download small-font-size-08"></i> Download PDF
                    </a>
                </div>
            </div>

            <div class="row">

                <div class="col-12 table-responsive">
                    <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                        <thead>
                        <tr class="small">
                            <th>#</th>
                            <th>ID</th>
                            <th>Coach</th>
                            <th>Zoom Email</th>
                            <th>Meeting Join Url</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($coaches as $coach)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$coach->id}}
                                </td>
                                <td>
                                    <a href="{{route('get.admin.coach.show', $coach->hashId())}}" class="mr-2" title="Show coach">
                                        {{$coach->writeFullName()}}
                                    </a>
                                </td>
                                <td>
                                    @if ($coach->zoomUser)
                                        {{$coach->zoomUser->zoom_email}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($coach->zoomMeeting)
                                        {{$coach->zoomMeeting->join_url}}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

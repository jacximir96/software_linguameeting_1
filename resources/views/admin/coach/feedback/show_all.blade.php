@extends('layouts.app_modal')

@section('content')

    <div class="row">


        <div class="col-12 table-responsive">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr class="small">
                    <th>Date</th>
                    <th>Recording</th>
                    <th>Download</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                @forelse ($viewData->feedbacks()->get() as $feedbackWrapper)

                    <tr>
                        <td>
                            <span class="d-block-inline">{{$feedbackWrapper->printMoment()}}</span>
                        </td>

                        <td class="text-left">
                            @if ($feedbackWrapper->hasRecordingUrl())
                                <a href="{{$feedbackWrapper->get()->recording_url}}" target="_blank" title="Show recording" >
                                    <i class="fa fa-play"></i> View
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{route('get.admin.coach.coach_feedback.download', $feedbackWrapper->get()->id)}}" title="Download feedback" >
                                <i class="fa fa-download"></i> Download
                            </a>
                        </td>

                        <td class="">
                            <a href="{{route('get.admin.coach.coach_feedback.show', $feedbackWrapper->get()->id)}}"
                               class=" text-primary me-2">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{route('get.admin.coach.coach_feedback.edit', $feedbackWrapper->get()->id)}}"
                               class="me-2"
                               title="Edit Feedback">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{route('get.admin.coach.coach_feedback.delete', $feedbackWrapper->get()->id)}}"
                               onclick="return confirm('Are you sure you want to delete this coach feedback?');"
                               title="Delete Feedback ">
                                <i class="fa fa-times text-danger"></i>
                            </a>

                        </td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="3">
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No feedbacks registered</span>
                        </td>
                    </tr>

                @endforelse
                </tbody>
            </table>
            {{$viewData->paginator()->render()}}
        </div>
    </div>

@endsection

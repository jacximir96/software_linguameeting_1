<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-comments me-1"></i> Feedbacks
        </span>

        <a href="{{route('get.admin.coach.coach_feedback.create', $coach->hashId())}}"
           title="Assign feedback to {{$coach->writeFullName()}}"
           class="open-modal d-block text-success fw-bold"
           data-modal-size="modal-xl"
           data-modal-reload="yes"
           data-reload-type="parent"
           data-modal-title='Create Feedback'>
            <i class="fa fa-plus text-success"></i> Create Feedback
        </a>
    </div>
    <div class="card-body">
        <div class="row d-none d-sm-block">
            <div class="col-12">

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

                    @forelse ($feedbacks->get() as $feedbackWrapper)

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
                                   class="open-modal text-primary me-2"
                                   data-modal-size="modal-xl"
                                   data-modal-reload="no"
                                   data-reload-type="parent"
                                   data-modal-title="Show feedback of: {{$coach->writeFullName()}}">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="{{route('get.admin.coach.coach_feedback.edit', $feedbackWrapper->get()->id)}}"
                                   class="open-modal me-2"
                                   data-modal-size="modal-xl"
                                   data-modal-reload="yes"
                                   data-reload-type="parent"
                                   data-modal-title='Edit Feedback'
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
            </div>
        </div>

        <div class="row d-block d-sm-none">

            <div class="col-12">
                @if ($feedbacks->hasFeedbacks())
                    <ul>
                        @foreach ($feedbacks->get() as $feedback)
                            <li class="mb-3">
                                <span class="d-block">{{toDate($feedbackWrapper->moment())}}</span>
                                <span class="d-block mb-2">
                                    @if ($feedbackWrapper->hasRecordingUrl())
                                        <a href="{{$feedbackWrapper->get()->recording_url}}" target="_blank" title="Show recording" >
                                        <i class="fa fa-play"></i> View Recording
                                    </a>
                                    @else
                                        -
                                    @endif
                                </span>
                                <span class="d-block mb-2">
                                    <a href="{{route('get.admin.coach.coach_feedback.download', $feedbackWrapper->get()->id)}}" title="Download feedback" >
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </span>

                                <a href="{{route('get.admin.coach.coach_feedback.show', $feedbackWrapper->get()->id)}}"
                                   class="open-modal text-primary me-3"
                                   data-modal-size="modal-xl"
                                   data-modal-reload="no"
                                   data-reload-type="parent"
                                   data-modal-title="Show feedback of: {{$coach->writeFullName()}}">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="{{route('get.admin.coach.coach_feedback.edit', $feedbackWrapper->get()->id)}}"
                                   class="open-modal me-3"
                                   data-modal-size="modal-xl"
                                   data-modal-reload="yes"
                                   data-reload-type="parent"
                                   data-modal-title='Edit Feedback'
                                   title="Edit Feedback">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="{{route('get.admin.coach.coach_feedback.delete', $feedbackWrapper->get()->id)}}"
                                   onclick="return confirm('Are you sure you want to delete this coach feedback?');"
                                   title="Delete Feedback ">
                                    <i class="fa fa-times text-danger"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class=" text-white bg-warning px-2 py-1 rounded ">No feedbacks registered</span>
                @endif
            </div>

        </div>

        @if ($feedbacks->hasFeedbacks())
            <a href="{{route('get.admin.coach.coach_feedback.show_all', $coach->hashId())}}"
               class="open-modal d-block mt-1 text-primary float-end"
               data-modal-size="modal-xl"
               data-modal-reload="no"
               data-reload-type="parent"
               data-modal-title="Show all feedbacks of: {{$coach->writeFullName()}}">
                <i class="fa fa-list"></i> Show all
            </a>
        @endif
    </div>
</div>

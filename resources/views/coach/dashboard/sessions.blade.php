<div class="card">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-headphones me-1"></i>
            Sessions
        </span>
    </div>
    <div class="card-body">

        <div class="row">
            @if ($viewData->sessions()->count())
                <div class="col-12 d-flex justify-content-between">
                    <p class="bg-corporate-color-light px-1 fw-bold">Sessions Today</p>
                    <p class="fw-bold small"><span class="fw-bold text-success">{{$viewData->sessions()->count()}} sessions</span></p>
                </div>
                <div class="col-12">
                    <table id="" class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="w-40">Hour</th>
                            <th class="w-50">Course</th>
                            <th class="w-10">Students</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($viewData->sessions() as $session)

                            @php $momentStart = $session->createTime('start_time') @endphp
                            @php $momentEnd = $session->createTime('end_time') @endphp

                            <tr>
                                <td>
                                    <a href="{{route('get.coach.calendar.availability.session.show', $session->hashId())}}"
                                       class="open-modal"
                                       data-modal-reload="no"
                                       data-modal-size="modal-xl"
                                       data-modal-height="h-95"
                                       data-reload-type="parent"
                                       data-modal-title="Session Data"
                                       title="Show Assignments and Session Data">

                                        {{toTime24h($momentStart)}}<br>{{toTime24h($momentEnd)}}
                                        @if ($session->isPast($timezone))
                                            <span class="text-success fw-bold text-decoration-underline small  p-1 d-inline-block ms-2">Celebrada</span>
                                        @endif
                                    </a>

                                </td>
                                <td>
                                    <span class="d-block">
                                        {{$session->course->name}} ({{$session->course->conversationPackage->sessionType->code}})
                                    </span>
                                    <span class="d-block small">{{$session->course->university->name}}</span>
                                </td>
                                <td>
                                    {{$session->enrollmentSession->count()}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-12  mt-2 d-flex justify-content-between">
                    <a href="{{$coach->zoomMeeting->start_url}}" class="btn bg-success btn-xs text-white text-end" title="Go to Zoom">Start</a>
                    <a href="{{route('get.coach.class.today.index')}}" class="text-decoration-underline" title="Go To Class">Go to Class</a>
                </div>
            @else
                <div class="row mt-2">
                    <div class="col-12">
                        <p class="p-2 rounded bg-corporate-color-light fw-bold">Hoy no tienes clase.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

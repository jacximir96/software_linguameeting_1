@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-headphones me-1"></i>
                Today Class
            </span>

        </div>
        <div class="card-body col-xl-6 offset-xl-3">

            <div class="row">
                <div class="col-12 col-xl-6 text-corporate-color my-3 h6">
                    <i class="fa fa-clock"></i>
                    <span id="clock_spain" class="fw-bold"></span> ({{userTimezoneName()}})
                </div>

                <div class="col-12 col-xl-6 text-end">
                    <a href="{{$coach->zoomMeeting->start_url}}" class="btn bg-success text-white text-end" title="Go to Zoom">Start</a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <span class="bg-corporate-color-light fw-bold p-2 rounded d-block mt-3">
                        @if ($sessions->count())
                            Today Sessions: <span class="fw-bold">{{$sessions->count()}}</span>
                        @else
                            Hoy no tienes clase.
                        @endif
                    </span>
                </div>
            </div>

            @foreach ($sessions as $session)

                @php $momentStart = $session->createTime('start_time') @endphp
                @php $momentEnd = $session->createTime('end_time') @endphp

                <div class="row border rounded mb-4 p-2">

                    <div class="col-xl-6">

                        <div class="row mt-2">
                            <div class="col-xl-3">
                                <span class="fw-bold d-inline-block me-3">Hour</span>
                            </div>
                            <div class="col-xl-9">
                                <span class="bg-corporate-color-light fw-bold text-success">{{toTime24h($momentStart)}} - {{toTime24h($momentEnd)}}</span>

                                @if ($session->isPast())
                                    <span class="badge bg-success p-1 d-inline-block ms-3">Celebrada</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-xl-3">
                                <span class="fw-bold d-inline-block me-3">University</span>
                            </div>
                            <div class="col-xl-9">
                                <span class="">{{$session->course->university->name}}</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-xl-3">
                                <span class="fw-bold d-inline-block me-3">Course</span>
                            </div>
                            <div class="col-xl-9">
                                <span class="">{{$session->course->name}}</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-xl-3">
                                <span class="fw-bold d-inline-block me-3">Type</span>
                            </div>
                            <div class="col-xl-9">
                                <span class="">{{$session->course->conversationPackage->sessionType->name}}</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-xl-3">
                                <span class="fw-bold d-inline-block me-3">Flex</span>
                            </div>
                            <div class="col-xl-9">
                                <span class="">{{$session->course->isFlex() ? 'Yes' : 'No'}}</span>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-xl-3">
                                <span class="fw-bold d-inline-block me-3">Assignments</span>
                            </div>
                            <div class="col-xl-5">
                                <a href="{{route('get.coach.calendar.availability.session.show', $session->hashId())}}"
                                   class="open-modal"
                                   data-modal-reload="no"
                                   data-modal-size="modal-xl"
                                   data-modal-height="h-95"
                                   data-reload-type="parent"
                                   data-modal-title="Session Data"
                                   title="Show Assignments and Session Data">
                                    View Assignments
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <span class="d-block mt-2">
                            <i class="fa fa-users"></i> Students
                        </span>
                        @if ( ! $session->occupation()->isEmpty())
                            <ul class="mt-2">
                                @foreach ($session->enrollmentSession as $enrollmentSession)
                                    <li>
                                        <span class="d-inline-block me-1">{{$enrollmentSession->enrollment->user->writeFullName()}}</span>

                                        @include('admin.student.accommodation.link', ['enrollment' => $enrollmentSession->enrollment])
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-corporate-danger">This class has no students.</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>

        setInterval(update, 1000);

        function update() {
            var date_coach = moment().tz('{{userTimezoneName()}}');
            $('#clock_spain').html(date_coach.format('D MMMM YYYY HH:mm:ss'));
        }
    </script>

@endsection

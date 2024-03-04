@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-calendar-day me-1"></i>
                Last Minute
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6">
                    <span class="small">...¿debería ir algo aquí?...</span>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-12">
                            <span class="d-block fw-bold">
                                Session {{$sessionOrder->get()}}
                            </span>
                            @if ($coachingWeek instanceof \App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek)
                                <span class="d-block text-muted small">
                                    {{toMonthDayAndYear($coachingWeek->start_date)}}, {{toMonthDayAndYear($coachingWeek->end_date)}}
                                </span>
                            @endif

                            <a href="{{route('get.student.enrollment.assignment.show_enrollment', $enrollment->hashId())}}"
                               class="open-modal d-block mt-2 text-corporate-danger"
                               data-modal-reload="no"
                               data-modal-size="modal-xl"
                               data-modal-height="h-90"
                               data-modal-title="Session Assignment"
                               title="Leave a tip">
                                View Assignments
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            @if ($viewData->sessions()->count())

                <div class="row mt-5">

                    <div class="col-xl-3 offset-xl-1 d-flex justify-content-between">

                        <span class="label d-block p-1 rounded bg-corporate-color text-white text-center small mx-2">
                            Available Session
                        </span>

                        <span class="label d-block p-1 rounded bg-corporate-danger text-white text-center small">
                            Booked Selected
                        </span>

                        <span class="label d-block p-1 rounded bg-session-selected text-white text-center small">
                            Session Selected
                        </span>

                    </div>
                </div>

                <div class="row mt-2">

                    <div class="col-12 col-xl-8 ">

                        <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                            <thead>
                            <tr>
                                <th class="">Hours</th>
                                <th></th>
                                <th>Coach</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($viewData->sessions() as $session)

                                <tr>
                                    <td class="w-30">
                                        <span class="d-block">{{toMonthDayYear($session->scheduleSession()->date(), $userTimezone->name)}}</span>
                                        <span class="d-block">{{toTime24h($session->scheduleSession()->date(), $userTimezone->name)}}</span>
                                    </td>

                                    <td class="w-30">
                                        <a href="#"
                                           class="d-inline-block text-corporate-danger btn bg-corporate-color text-white"
                                           data-bs-toggle="modal"
                                           data-bs-target="#modal-select-session-{{$session->hashId()}}">
                                            <span class="d-inline-block me-2">
                                                {{ ($session->course->student_class - $session->enrollmentSession->count() ) }}/{{$session->course->student_class}}
                                            </span>

                                            <span class="d-inline-block">
                                                available spots
                                            </span>
                                        </a>

                                        @include('common.modal_info', [
                                            'coach' => $session->coach,
                                            'coachSchedule' => $session->coachSchedule->first(),
                                            'formId' => 'select-session-form-'.$session->hashId(),
                                            'modalId' => 'modal-select-session-'.$session->hashId(),
                                            'modalTitle' => 'Select Session',
                                            'noFooter' => true,
                                            'path' => 'student.enrollment.session.last-minute.modal_select_session',
                                            'session' => $session,
                                            'size' => 'modal-md',
                                            'studentTimezone' => $userTimezone,
                                            'timezone' => $userTimezone,
                                        ])

                                    </td>

                                    <td>
                                        <span class="d-block fw-bold">{{$session->coach->writeFullNameAndLastname()}}</span>

                                        <div>
                                            <img src="{{asset('assets/img/flags/'.$session->coach->country->flagFile())}}"
                                                 title="Flag of {{$session->coach->country->name}}"
                                                 class="img-thumbnail flag-icon-25 me-20"/>
                                            <span class="d-inline-block ms-2 text-muted small">{{$session->coach->country->name}}</span>
                                        </div>

                                        @include('common.modal_info', [
                                            'modalId' => 'modal-coach-'.$session->coach->hashId(),
                                            'modalTitle' => 'Coach '.$session->coach->writeFullNameAndLastname(),
                                            'size' => 'modal-md',
                                            'path' => 'student.enrollment.session.modal_info_coach',
                                            'coach' => $session->coach,
                                            'reviewsStats' => $reviewsStatsCollection->getByCoach($session->coach)->reviewsStats(),
                                        ])

                                        @php $reviewsStats = $reviewsStatsCollection->getByCoach($session->coach)->reviewsStats() @endphp

                                        @if ($reviewsStats)
                                            <div class="small">
                                                @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                                                <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
                                            </div>

                                        @endif

                                        <a href="#"
                                           class="d-block mt-1 text-corporate-dark-color small"
                                           data-bs-toggle="modal"
                                           data-bs-target="#modal-coach-{{$session->coach->hashId()}}">
                                            View <i class="fa fa-eye"></i>
                                        </a>

                                    </td>

                                </tr>

                            @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>

            @else

                <p>No se han encontrado sesiones last minute...(traducir) </p>

            @endif
        </div>
    </div>
@endsection

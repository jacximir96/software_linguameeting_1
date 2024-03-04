@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-calendar-day me-1"></i>
                @if (session()->has('isMakeup'))
                    Create Make-up
                @else
                    Book Session
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-md-5">

                    @php
                        $availabilityTimeHour = $viewData->availability()->first();
                        $coachFreeSlots = $availabilityTimeHour->coachFreeSlots()->first();
                        $coach = $coachFreeSlots->coach()
                    @endphp


                    <div class="col-12">
                        @if ($coach->profileImage)
                            <img src="{{asset($coach->profileImage->url()->get())}}" class="img-fluid w-25 float-start me-3 mb-3" alt="Coach Photo">
                        @else
                            <img src="{{asset('assets/img/web/anonymous_user.png')}}" class="img-fluid w-25 float-start me-3 mb-3" alt="Coach Photo">
                        @endif

                        <span class="d-block fw-bold">
                            {{$coachFreeSlots->coach()->writeFullName()}}
                        </span>

                        <div class="mt-2">
                            <img src="{{asset('assets/img/flags/'.$coach->country->flagFile())}}"
                                 title="Flag of {{$coach->country->name}}"
                                 class="img-thumbnail flag-icon-25 me-20" />

                            <span class="d-inline-block">
                                {{$coach->country->name}}
                            </span>
                        </div>

                        <div class="mt-2">
                            @php $reviewsStats = $viewData->reviewsStatsCollection()->getByCoach($coach)->reviewsStats() @endphp

                            @if ($reviewsStats)
                                <div class="small">
                                    @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                                    <span class="small fst-italic ms-2">{{$reviewsStats->total()}}</span>
                                </div>

                            @endif
                        </div>



                        <p class="mt-2">
                            <span class="fw-bold text-corporate-color me-2">Le gusta</span>

                            {{ $coach->hobby->implode(function ($hobby){
                                    return $hobby->description;
                            }, ', ')   }}
                        </p>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold text-corporate-color me-2">About me</span>
                        {!! $coach->coachInfo->description !!}
                    </div>

                </div>

                <div class="col-md-7">

                    @if ($coachFreeSlots->hasFreeSlots())
                        <span class="bg-corporate-color-light fw-bold p-1">Availability to {{toDate($coachFreeSlots->date($enrollment->user->timezone))}}</span>
                    @endif

                    <table align="left" class="table table-bordered table-responsive mt-2" cellpadding="1" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Hours</th>
                            <th>Availability</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($coachFreeSlots->freeSlots() as $freeSlots)

                            @php $formId = $freeSlots->first()->hashId() @endphp


                            {{ Form::model($selectSessionForm->model(),  [
                                         'class' => '',
                                         'url'=> $selectSessionForm->buildAction($freeSlots)->get(),
                                         'autocomplete' => 'off',
                                         'id' =>'select-session-form-'.$formId])
                                   }}
                                    @foreach ($selectSessionForm->model() as $field=>$value)
                                        <input type="hidden" name="{{$field}}" value="{{$value}}" />
                                    @endforeach

                                    @foreach ($selectSessionForm->coachScheduleIds() as $coachScheduleId)
                                        <input type="hidden" name="coach_schedule_id[]" value="{{$coachScheduleId}}" />
                                    @endforeach
                                <tr>
                                    <td class="text-center">
                                        {{toTime24h($freeSlots->first()->startTime(), $studentTimezone)}}
                                    </td>
                                    <td>

                                        <a href="#"
                                           class="d-inline-block text-corporate-danger btn bg-corporate-color text-white"
                                           data-bs-toggle="modal"
                                           data-bs-target="#modal-select-session-{{$formId}}">

                                            <span class="d-inline-block me-2">
                                                @php $session = $freeSlots->first()->session @endphp
                                                @if ($session)
                                                    {{ ($course->student_class - $session->enrollmentSession->count() ) }}/{{$course->student_class}}
                                                @else
                                                    {{$course->student_class}}/{{$course->student_class}}
                                                @endif
                                            </span>

                                            <span class="d-inline-block">
                                                available spots
                                            </span>

                                        </a>

                                        @include('common.modal_info', [
                                            'modalId' => 'modal-select-session-'.$formId,
                                            'modalTitle' => 'Select Session',
                                            'size' => 'modal-md',
                                            'path' => 'student.enrollment.session.book.modal_select_session',
                                            'coach' => $coach,
                                            'coachSchedule' => $freeSlots->first(),
                                            'timezone' => $enrollment->user->timezone,
                                            'formId' => 'select-session-form-'.$formId,
                                            'noFooter' => true,
                                        ])

                                    </td>
                                </tr>
                            {{Form::close()}}
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {

            jQuery(document).on('click', '#select-session-button', function (event) {

                event.preventDefault()

                var formId = $(this).data('form-id')

                $('#'+formId).submit()
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="col-xl-6">
           Course info
        </div>

        <div class="col-xl-6">
            @foreach ($viewData->course()->coachingWeeksOrdered() as $coachingWeek)

                <div class="mt-2 p-2 border" >

                    {{$coachingWeek->session_order}} - {{$coachingWeek->start_date->format('Y-m-d')}} - {{$coachingWeek->end_date->format('Y-m-d')}}

                    @if ($enrollmentFacade->hasSessionInCoachingWeek ($coachingWeek))
                        @php $enrollmentSession = $enrollmentFacade->enrollmentSessionByCoachingWeek ($coachingWeek) @endphp

                        @include('student-role.course.show.session_coach', ['coach' => $enrollmentSession->session()->coach])

                        @include('student-role.course.show.session_schedule', ['enrollmentSessionFacade' => $enrollmentSession])

                    @else


                        <a href="{{route('get.student.session.book.create.search_coach', [$viewData->enrollment()->id, $coachingWeek->session_order])}}"
                           class="open-modal text-decoration-underline fw-bold"
                           data-modal-size="modal-xl"
                           data-modal-reload="yes"
                           data-reload-type="parent"
                           data-modal-title='Book Session'>
                            Book Session
                        </a>

                    @endif



                </div>

            @endforeach
        </div>
    </div>
@endsection

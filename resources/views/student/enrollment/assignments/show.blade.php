@extends('layouts.app_modal')

@section('content')

    <div class="row mt-1">
        <div class="col-12 h5">
            <span class="d-inline-block fw-bold">
                {{$viewData->section()->course->university->name}}
            </span>

            <span class="d-inline-block fw-bold text-corporate-dark-color">
                {{$viewData->section()->course->name}}
            </span>
        </div>

    </div>

    <div class="row mt-3 fw-bold">
        <div class="col-3 bg-corporate-color-light py-1" >Session</div>
        <div class="col-6 bg-corporate-color-light py-1">Assignment</div>
        <div class="col-3 bg-corporate-color-light py-1">

        </div>
    </div>

    <div class="row mt-2">
        @foreach ($viewData->sessionWeeks()->orderByNumberSession() as $sessionWeek)
            <?php //La variable $sessionWeek puede ser también una instancia de App\Src\CourseDomain\Flex\Service\FlexSession ?>

            @if ($sessionWeek instanceof \App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek)
                @if ($sessionWeek->isMakeup())
                    @continue
                @endif
            @endif

            <div class="col-12 mb-3 border-bottom">

                <div class="row {{$sessionWeek->sessionOrderObject()->isSame($sessionWeek->sessionOrderObject()) ? 'bg-green-lighter' : ''}}">

                    <div class="col-3 text-left">
                        <span class="d-block fw-bold">
                            {{$sessionWeek->writeSessionNumber()}}
                        </span>
                        @if ($sessionWeek instanceof \App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek)
                            <span class="d-block text-muted small">
                                {{toMonthShortAndDay($sessionWeek->start_date)}} to {{toMonthShortAndDay($sessionWeek->end_date)}}
                            </span>
                        @endif
                    </div>

                    @php $assignment = $viewData->assignmentCollection()->getBySessionOrder($sessionWeek->sessionOrderObject()) @endphp

                    <div class="col-9">

                        @if ($assignment)
                            @include('student.enrollment.assignments.chapter', ['assignment' => $assignment])

                        @else
                            <span class="text-corporate-danger">No Assignment</span>
                        @endif

                        @if ($assignment)
                            @include('student.enrollment.assignments.other', ['assignment' => $assignment])
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>




@endsection

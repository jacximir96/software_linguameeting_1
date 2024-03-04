@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-5">
            @include('student.calendar.session.info_session', ['session' => $session])
        </div>
        <div class="col-7">
            @include('student.calendar.session.info_course', ['course' => $session->course])
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-12">
            <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-book"></i> Assignments</span>
        </div>
    </div>


    <div class="row mt-2">

        <div class="col-12">
            @if ($viewData->sessionAssignment()->hasAssignment())
                @include('admin.coach.calendar.session.info_assignment', ['assignment' => $viewData->sessionAssignment()->assignment()])
            @elseif($viewData->makeupSessionsAssignments()->count())

                @foreach ($viewData->makeupSessionsAssignments() as $makeupSessionAssignment)
                    @include('admin.coach.calendar.session.info_assignment', ['assignment' => $makeupSessionAssignment])
                @endforeach

            @else
                <p class="mt-1 text-danger">
                    Assignments not exists for this session.
                </p>
            @endif
        </div>
    </div>



@endsection

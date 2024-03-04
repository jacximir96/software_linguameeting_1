@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-5">
            @include('admin.coach.calendar.session.info_session', ['session' => $session])
        </div>
        <div class="col-7">
            @include('admin.coach.calendar.session.info_course', ['course' => $session->course])
        </div>
    </div>

    @include('admin.coach.calendar.session.info_students')

    @if ($viewData->makeupSessionsAssignments()->count())
        @include('admin.coach.calendar.session.info_students_makeups')
    @endif

    @if (user()->isAdmin())
        <div class="row">
            <div class="col-12 text-end">
                <a href="{{route('get.admin.coach.calendar.availability.session.change_coach', $session->id)}}"
                   title="Change Coach"
                   class="btn btn-primary btn-xs text-white">
                    <i class="fa fa-exchange-alt"></i> Change Coach
                </a>
            </div>
        </div>
    @endif

@endsection

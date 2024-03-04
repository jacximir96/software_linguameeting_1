@extends('layouts.app_modal')

@section('content')

    <div class="row text-start">

        <div class="col-12 mt-2">
        <span class="text-primary fw-bold">
            Do you wish to select this time?
        </span>
        </div>

        <div class="col-12 mt-2">
            <span class="fw-bold">{{toTime24h($session->moment(), $userTimezone->name)}}</span> on
            <span class="fw-bold">{{toMonthDayYear($session->moment(), $userTimezone->name)}}</span> with coach:
        </div>

        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-12">
                    @include('student.enrollment.session.api.info_coach_modal', [
                       'coach' => $coach,
                       'reviewsStats' => $reviewsStatsCollection->getByCoach($coach)->reviewsStats(),
                       'imageWidth' => 'w-50',
                   ])
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 text-end">
                    <a href="{{route('get.student.session.book.session.schedule', [$session->session()->hashId(), $enrollment->hashId(), $sessionOrder->get()])}}" class="btn btn-sm bg-corporate-color text-white me-3">Yes</a>
                    <a href="#"
                       class="btn btn-sm bg-gray text-white close-modal"
                       data-bs-dismiss="modal"
                    >No</a>
                </div>
            </div>
        </div>
    </div>

@endsection

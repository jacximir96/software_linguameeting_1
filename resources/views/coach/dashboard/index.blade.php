@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-12 col-xl-4">
            @include('coach.dashboard.sessions')
        </div>

        <div class="col-12 col-xl-4">
            @include('coach.dashboard.notifications')
        </div>

        <div class="col-12 col-xl-4">
            @include('coach.dashboard.messaging')
            @include('coach.dashboard.reviews')
        </div>
    </div>

    <div class="row my-3">
        <div class="col-12 text-end">
            <a href="{{route('get.coach.calendar.google.generate')}}"
               class="open-modal text-primary"
               data-modal-reload="no"
               data-modal-size="modal-lg"
               data-reload-type="parent"
               data-modal-title='Generate Calendar for Google'>
                <i class="fa fa-calendar-day"></i> Generate Calendar for Google
            </a>
        </div>
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-calendar-day me-1"></i>
                    Calendar
                </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('calendar.javascript', ['user' => $coach])


@endsection

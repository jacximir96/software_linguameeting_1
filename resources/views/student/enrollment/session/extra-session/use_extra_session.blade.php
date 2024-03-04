@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color ">
            <span class="fw-bold">
                <i class="fas fa-calendar-day me-1"></i>
                Extra Session
            </span>
        </div>

        <div class="card-body mb-5">

            <div class="row mt-2">
                <p class="text-corporate-danger small">
                    <span class="d-block fw-bold">IMPORTANT</span>
                    <span class="d-block">Sessions must be scheduled at least 12 hours in advance.</span>
                    <span class="d-block">You must reschedule your session up to 5 hours prior.</span>
                </p>
            </div>

            @if ($course->isFlex())
                @include('student.enrollment.session.extra-session.in_flex_course')

            @else
                @include('student.enrollment.session.extra-session.in_weeks_course')

            @endif

        </div>
    </div>
@endsection

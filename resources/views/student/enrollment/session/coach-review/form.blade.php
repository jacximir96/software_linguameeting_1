@extends('layouts.app_modal')

@section('content')

    <div class="row">
        <div class="col-12 border-bottom">
            <span class="text-corporate-dark-color fw-bold">
                <i class="fas fa-star me-1 text-warning"></i>
                Did you enjoy your session?
            </span>
        </div>

    </div>

    <div class="row mt-4">
        @if (isset($coachReviewExists) AND $coachReviewExists)
            <div class="col-12">
                <span class="text-warning-dark fw-bold">
                    There is already a rating for this session.<br>Close this window to continue.
                </span>
            </div>
        @else
            @include('student.enrollment.session.coach-review.create_form')
        @endif
    </div>

@endsection

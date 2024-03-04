@extends('layouts.app_modal')

@section('content')


    <div class="row d-flex">

        <div class="col-12">
            @include('admin.coach.feedback.feedback_header')
        </div>

        <div class="col-12 mt-3">
            @if ($wrapper->language()->isSpanish())
                @include('admin.coach.feedback.feedback_data_es')
            @else
                @include('admin.coach.feedback.feedback_data_en')
            @endif

        </div>
    </div>

@endsection

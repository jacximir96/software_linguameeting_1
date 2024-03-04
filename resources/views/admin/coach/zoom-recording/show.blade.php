@extends('layouts.app_modal')

@section('content')


    <div class="row d-flex">

        <div class="col-12">
            @include('admin.coach.zoom-recording.show_header')
        </div>

        <div class="col-12 mt-3">
            @include('admin.coach.zoom-recording.show_students')
        </div>

    </div>

@endsection

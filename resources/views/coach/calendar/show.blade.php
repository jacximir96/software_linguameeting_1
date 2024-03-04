@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-calendar-day me-1"></i>
                        Calendar
                    </span>
                    <span>{{$timezone->name}}</span>
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

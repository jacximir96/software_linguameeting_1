@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="col-12 text-end">
            <a href="{{route('get.student.calendar.google.generate')}}"
               class="open-modal border rounded text-corporate-dark-color fw-bold btn btn-sm bg-corporate-color-light"
               data-modal-reload="no"
               data-modal-size="modal-md"
               data-reload-type="parent"
               data-modal-title='Generate Calendar for Google'>
                <i class="fa fa-download"></i> Generate Calendar for Google
            </a>
        </div>
        <div class="col-12 mt-3">

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

    @include('calendar.javascript', ['user' => $student])

@endsection

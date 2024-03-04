@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-calendar-day me-1"></i>
                Suggestins For Next Session
            </span>
        </div>
        <div class="card-body mb-5">

            <div class="row">
                <div class="col-xl-6">
                    <div class="row ">

                        <div class="col-12">
                            <span class="d-block fw-bold bg-corporate-color text-white p-1 rounded">
                                Suggestions for next sessions.
                            </span>
                        </div>

                        <div class="col-12 mt-4 ">
                            <div class="row">
                                <div class="col-12 ps-4">
                                   <span class="bg-corporate-color-light text-corporate-dark-color fw-bolder p-1 h6">
                                        Hola caracola
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-5 " id="div-info-weeks">
                            <div class="row">
                                <div class="col-12">
                                    <span class="text-corporate-dark-color fw-bold">
                                        Would you like to book all sessions with {{$enrollmentSession->session->coach->writeFullNameAndLastName()}}?
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

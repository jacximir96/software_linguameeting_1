@extends('layouts.app')

@section('content')

    <div class="col-12 mt-4">
        @include('student.help.zoom_help')
    </div>

    <div class="col-12 mt-4 mb-5">

        <div class="container px-4">
            <div class="row gx-5">

                <div class="col-lg-6">

                    <div class="row mt-3">
                        <div class="col-12 bg-corporate-color-light rounded p-1 fw-bold">
                            Hardware Requirements
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 ps-4">
                            <p>
                                    <span class="fw-bold d-inline-block me-3">
                                        <i class="fa fa-chevron-right fa-sm d-inline-block me-2"></i> Operating System:
                                    </span>
                                <a href="https://support.zoom.us/hc/en-us/articles/201362023-System-Requirements-for-PC-Mac-and-Linux"
                                   target="_blank"
                                   title="See System Requirements">
                                    See System Requirements
                                </a>
                            </p>
                        </div>

                        <div class="col-12 ps-4">
                            <p>
                                    <span class="fw-bold d-inline-block me-3">
                                        <i class="fa fa-chevron-right fa-sm d-inline-block me-2"></i> Internet Connection:
                                    </span>
                                <span class="bg-corporate-color-light p-1">
                                        Wired preferred vs wireless for better quality
                                    </span>
                            </p>
                        </div>

                        <div class="col-12 ps-4">
                            <p>
                                    <span class="fw-bold d-inline-block me-3">
                                        <i class="fa fa-chevron-right fa-sm d-inline-block me-2"></i> Communication Device:
                                    </span>
                                <span class="bg-corporate-color-light p-1">
                                        Headset/earphones with mic
                                    </span>
                            </p>
                        </div>
                    </div>


                    @php $typeId = null; $cont = 1; @endphp
                    @foreach ($helps as $help)

                        @if ($help->student_help_type_id != $typeId)
                            @php $typeId = $help->student_help_type_id; $cont = 1; @endphp

                            <div class="row mt-3">
                                <div class="col-12 bg-corporate-color-light rounded p-1 fw-bold">
                                    {{$help->type->name}}
                                </div>
                            </div>
                        @endif

                        <div class="row mt-2">
                            <div class="col-12 ps-4">
                                <a href="{{$help->url}}" target="_blank" class="me-3" title="Go to {{$help->description}}">
                                    <span class="text-dark">{{$cont}}.</span> <span>{{$help->description}}</span>
                                </a>
                            </div>
                        </div>
                        @php $cont++ @endphp
                    @endforeach

                </div>
                <div class="col-lg-6">
                    <div class="col-12 mt-3">
                        <div class="col-12 bg-corporate-color-light rounded p-1 fw-bold">
                            Contact US
                        </div>
                    </div>

                    @include('student.help.contact_form')

                </div>
            </div>
        </div>
    </div>

@endsection

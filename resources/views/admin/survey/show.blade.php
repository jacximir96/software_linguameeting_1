@extends('layouts.app_modal')

@section('content')

    <div class="row d-flex">

        <div class="col-12">
            <div class="card">
                <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="m-0 font-weight-bold"><i class="fa fa-headphones"></i> Survey</span>
                </div>
                <div class="card-body padding-05-rem">

                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="my-0">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Date</span>
                                <span>{{toDate($survey->created_at)}}</span>
                            </p>
                        </div>

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Active</span>
                                <span class="d-inline-block">
                                    @if ($survey->isActive())
                                        <span class="text-success">Yes</span>
                                    @else
                                        <span class="text-danger">No</span>
                                    @endif
                                </span>
                            </p>
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Description</span>
                                <span class="d-block">{{$survey->description}}</span>
                            </p>
                        </div>

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Url</span>
                                <a href="{{$survey->url}}" class="mr-2" title="Go to survey" target="_blank">
                                    {{$survey->url}}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="row mt-4">

                        <div class="col-12 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Observations</span>
                                {!! $survey->observations ?? '-'!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@extends('layouts.app')

@section('content')

    @include('user.row_status', ['user' => $coach])

    <div class="row my-3">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-calendar me-1"></i>
                    Calendar
                </span>
                </div>
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-12">
                            <p class="border-bottom">
                                <span class="fw-bold"><i class="fa fa-chalkboard-teacher fa-w-20 me-2"></i> Coach</span>
                                <a href="{{route('get.admin.coach.show', $coach->hashId())}}" class="ms-2">{{$coach->writeFullName()}}</a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <h6 class="bg-corporate-color-light text-corporate-dark-color fw-bold p-2 rounded">
                                <i class="fa fa-headphones"></i> Active Courses
                            </h6>
                        </div>

                        <div class="col-12">
                            <div class="row">

                                @foreach ($viewData->sortedUniversities() as $viewUniversity)
                                    <div class="col-xl-4">
                                        <div class="card mb-4">
                                            <div class="card-header d-flex justify-content-between bg-corporate-color-light">
                                                <span class="text-corporate-dark-color fw-bold">
                                                    {{$viewUniversity->university()->name}}
                                                </span>
                                            </div>
                                            <div class="card-body">

                                                <div class="row">

                                                    @foreach ($viewUniversity->courses() as $course)
                                                        <div class="col-12 mb-2 rounded py-3" style="background-color: {{$course->color}}">
                                                                {{$course->name}}
                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('calendar.javascript', ['user' => $coach])

@endsection

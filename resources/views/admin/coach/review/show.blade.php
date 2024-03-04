@extends('layouts.app_modal')

@section('content')

    <div class="row d-flex">

        <div class="col-12">
            <div class="card">
                <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="m-0 font-weight-bold"><i class="fa fa-headphones"></i> Course</span>
                </div>
                <div class="card-body padding-05-rem">

                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="my-0">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block ">Date</span>
                                <span>{{toDate($review->session()->startTime(userTimezoneName()))}}</span>
                            </p>
                        </div>

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Rate</span>
                                @include('admin.coach.print_stars', ['ratingStar' => $review->stars])
                                <span class="d-inline-block">{{$review->stars}}</span>
                            </p>
                        </div>

                    </div>

                    <div class="row mt-2">

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Student</span>
                                <a href="{{route('get.admin.student.show', $review->student()->id)}}" class="mr-2" title="Show Coach" target="_blank">
                                    {{$review->student()->writeFullName()}}
                                </a>
                            </p>
                        </div>

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Course</span>
                                <a href="{{route('get.admin.course.show', $review->course()->id)}}" class="mr-2" title="Show University" target="_blank">
                                    {{$review->course()->name}}
                                </a>
                            </p>
                        </div>

                        <div class="col-6 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">University</span>
                                <a href="{{route('get.admin.university.show', $review->university()->id)}}" class="mr-2" title="Show University" target="_blank">
                                    {{$review->university()->name}}
                                </a>
                            </p>
                        </div>

                    </div>

                    <div class="row mt-2">

                        <div class="col-12 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Category</span>
                                <ul class="ul-two-columns">
                                    @foreach ($review->coachReviewOption as $reviewOption)
                                        <li>{{$reviewOption->option->name}}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>

                        <div class="col-12 col-md-4">
                            <p class="my-0 ">
                                <span class="small d-inline-block text-corporate-dark-color fw-bold d-block">Comment</span>
                                {{$review->comment ?? '-'}}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

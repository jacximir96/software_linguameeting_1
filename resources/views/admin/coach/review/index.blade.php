@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Reviews</h6>
        </div>
        <div class="card-body">
            @include('admin.coach.review.search_form')
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-star me-1"></i>
                Reviews
            </span>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-12 table-responsive">
                    {{$reviews->appends(request()->except(['_token']))->links()}}
                    <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                        <thead>
                        <tr class="small">
                            <th class="w-5">
                                @include('common.link_order', ['path' => 'post.admin.coach.review.search', 'field' => 'id', 'tag' => 'ID'])
                            </th>
                            <th class="w-5">
                                @include('common.link_order', ['path' => 'post.admin.coach.review.search', 'field' => 'date', 'tag' => 'Date'])
                            </th>
                            <th class="w-10 text-center">
                                @include('common.link_order', ['path' => 'post.admin.coach.review.search', 'field' => 'stars', 'tag' => 'Rating'])
                            </th>
                            <th class="w-10">
                                @include('common.link_order', ['path' => 'post.admin.coach.review.search', 'field' => 'coach', 'tag' => 'Coach'])
                            </th>
                            <th class="w-10">
                                @include('common.link_order', ['path' => 'post.admin.coach.review.search', 'field' => 'student', 'tag' => 'Student'])
                            </th>
                            <th class="w-15">
                                @include('common.link_order', ['path' => 'post.admin.coach.review.search', 'field' => 'university', 'tag' => 'University'])
                            </th>
                            <th class="w-25">Category</th>
                            <th class="w-20">Comment</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($reviews as $review)

                            <tr>
                                <td>{{$review->id}}</td>
                                <td>{{toDate($review->session()->startTime(userTimezoneName()))}}</td>
                                <td class="text-center">
                                    @include('admin.coach.print_stars', ['ratingStar' => $review->stars])
                                    <span class="d-block">{{$review->stars}}</span>
                                </td>
                                <td>
                                    <a href="{{route('get.admin.coach.show', $review->coach->hashId())}}" class="mr-2" title="Show Coach" target="_blank">
                                        {{$review->coach->writeFullName()}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('get.admin.student.show', $review->student()->id)}}" class="mr-2" title="Show Student" target="_blank">
                                        {{$review->student()->writeFullName()}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('get.admin.university.show', $review->university()->id)}}" class="mr-2" title="Show University" target="_blank">
                                        {{$review->university()->name}}
                                    </a>
                                </td>

                                <td>
                                    <ul class="ul-two-columns">
                                        @foreach ($review->coachReviewOption as $reviewOption)
                                            <li>{{$reviewOption->option->name}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    {{$review->comment ?? ''}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$reviews->appends(request()->except(['_token']))->links()}}
                </div>
            </div>

        </div>
    </div>

@endsection

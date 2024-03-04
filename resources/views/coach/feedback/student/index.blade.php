@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header p-2 d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
           <span class="">
                <i class="fas fa-search me-1"></i>
                Search Feedbacks
            </span>
        </div>
        <div class="card-body">
            @include('coach.feedback.student.search_form')
        </div>
    </div>



    <div class="card my-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-star me-1"></i>
                Students Feedbacks
            </span>

        </div>
        <div class="card-body">

            <div class="row mt-2">
                <div class="col-12 col-sm-4 col-xl-2 ">
                    @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
                    <span class="small fst-italic ms-2">{{$reviewsStats->total()}} reviews</span>
                </div>
                <div class="col-12 col-sm-8  col-xl-6">
                    @if ($mostSelected->count())
                        @foreach ($mostSelected->take(3) as $selected)
                            <span class="d-inline-block me-3">
                                {{$selected->emoji()}} {{$selected->reviewOption()->name}}
                            </span>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="row mt-4">

                <div class="col-12">
                    {{$reviews->appends(request()->except(['_token']))->links()}}
                    <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                        <thead>
                        <tr class="small">
                            <th class="w-5">
                                ID
                            </th>
                            <th class="w-5">
                                Date
                            </th>
                            <th class="w-10 text-center">
                                Rating
                            </th>
                            <th class="w-15">
                                University
                            </th>
                            <th class="w-40">Category</th>
                            <th class="w-20">Comment</th>
                            <th class="w-5">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{$review->id}}</td>
                                <td>{{toDate($review->session()->startTime(), $timezone)}}</td>
                                <td class="text-center">
                                    @include('admin.coach.print_stars', ['ratingStar' => $review->stars])
                                    <span class="d-block">{{$review->stars}}</span>
                                </td>
                                <td>
                                    {{$review->university()->name}}
                                </td>
                                <td>
                                    <ul class="ul-two-columns">
                                        @foreach ($review->coachReviewOption as $reviewOption)
                                            <li>{{$reviewOption->option->name}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    {{$review->comment}}
                                </td>
                                <td>
                                    <a href="{{route('get.coach.feedback.student.favorite.mark', $review->hashId())}}"
                                       title="{{$review->isFavorite() ? 'Unmark as favorite' : 'Mark as favorite'}} "
                                       onclick="return confirm('Are you sure to mark as favourite this review?');">
                                        <i class="fa fa-heart {{$review->isFavorite() ? 'text-danger' : 'text-dark'}}"></i>
                                    </a>
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

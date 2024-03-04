@extends('layouts.app_modal')

@section('content')


    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-star me-1"></i>
                Reviews of {{$coach->writeFullName()}}
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
                                ID
                            </th>
                            <th class="w-5">
                                Date
                            </th>
                            <th class="w-10 text-center">
                                Rating
                            </th>
                            <th class="w-15">
                                Student
                            </th>
                            <th class="w-40">Category</th>
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
                                    <a href="{{route('get.admin.student.show', $review->student()->id)}}" class="mr-2 d-block" title="Show Student" target="_blank">
                                        {{$review->student()->writeFullName()}}
                                    </a>
                                    <a href="{{route('get.admin.university.show', $review->university()->id)}}" class="mr-2 d-block mt-2" title="Show University" target="_blank">
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
                                    {{$review->comment}}
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

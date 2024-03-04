<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-star me-1"></i> Last Reviews
        </span>
        <div>
            @include('admin.coach.print_stars', ['ratingStar' => $reviewsStats->average()])
            <span class="small fst-italic ms-2">{{$reviewsStats->total()}} reviews</span>
        </div>
    </div>
    <div class="card-body">
        <div class="row d-none d-sm-block">
            <div class="col-12">

                <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                    <thead>
                    <tr class="small">
                        <th>Date</th>
                        <th>Rating</th>
                        <th>Student</th>
                        <th>University</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse ($reviewsStats->reviews() as $review)
                        <tr>
                            <td>{{toDate($review->session()->startTime(userTimezoneName()))}}</td>

                            <td class="text-left">
                                @include('admin.coach.print_stars', ['ratingStar' => $review->stars])
                            </td>
                            <td class="text-left">
                                <a href="{{route('get.admin.student.show', $review->student()->id)}}" class="mr-2" title="Show Student" target="_blank">
                                    {{$review->student()->writeFullName()}}
                                </a>
                            </td>
                           <td class="text-left">
                               <a href="{{route('get.admin.university.show', $review->university()->id)}}" class="mr-2" title="Show University" target="_blank">
                                   {{$review->university()->name}}
                               </a>
                           </td>
                            <td>
                                <a href="{{route('get.admin.coach.review.show', $review->id)}}"
                                   class="open-modal d-block mt-1 text-primary float-end"
                                   data-modal-size="modal-md"
                                   data-modal-reload="no"
                                   data-modal-title="Show all reviews of: {{$coach->writeFullName()}}"
                                   title="Show Coach Review">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="3">
                                <span class=" text-white bg-warning px-2 py-1 rounded ">No reviews registered</span>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row d-block d-sm-none">

            <div class="col-12">
                @if ($reviewsStats->hasReviews())
                    <ul>
                        @foreach ($reviewsStats->reviews() as $review)
                            <li>
                                <span class="d-block">{{toDate($review->session()->startTime(userTimezoneName()))}}</span>
                                <span class="d-block">Rating: @include('admin.coach.print_stars', ['ratingStar' => $review->stars])</span>
                                <span class="d-block">Student:
                                    <a href="{{route('get.admin.student.show', $review->student()->id)}}" class="mr-2" title="Show Student" target="_blank">
                                    {{$review->student()->writeFullName()}}
                                </a></span>
                                <span class="d-block">University:

                                    <a href="{{route('get.admin.university.show', $review->university()->id)}}" class="mr-2" title="Show University" target="_blank">
                                   {{$review->university()->name}}
                               </a>

                                </span>
                                <span class="d-block">Comment: {{$review->comment ?? '-'}}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class=" text-white bg-warning px-2 py-1 rounded ">No reviews registered</span>
                @endif
            </div>

        </div>

        @if ($reviewsStats->hasReviews())
            <a href="{{route('get.admin.coach.review.show_all', $coach->hashId())}}"
               class="open-modal d-block mt-1 text-primary float-end"
               data-modal-size="modal-xl"
               data-modal-reload="no"
               data-reload-type="parent"
               data-modal-title="Show all reviews of: {{$coach->writeFullName()}}">
                <i class="fa fa-list"></i> Show all
            </a>
        @endif
    </div>
</div>

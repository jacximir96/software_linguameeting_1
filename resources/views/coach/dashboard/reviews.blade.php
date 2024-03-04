<div class="card mt-2">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                    <span class="">
                        <i class="fas fa-star me-1"></i>
                        Reviews
                    </span>

    </div>
    <div class="card-body">

        <div class="row mt-2">
            <div class="col-12">
                <p><span class="fw-bold text-corporate-color">{{$coach->name}}</span>, your students think you are: </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('admin.coach.print_stars', ['ratingStar' => $viewData->reviewsStats()->average()])
                <span class="small fst-italic ms-2">{{$viewData->reviewsStats()->total()}} reviews</span>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                @if ($viewData->reviewsMostSelected()->count())
                    @foreach ($viewData->reviewsMostSelected()->take(3) as $selected)
                        <span class="d-inline-block me-3">
                                {{$selected->emoji()}} {{$selected->reviewOption()->name}}
                            </span>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-end">
                <a href="{{route('get.coach.feedback.student.index')}}" class="text-decoration-underline" title="View All Reviews">View All Reviews</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <span class="d-block fw-bold">{{$experience->title}}</span>
    </div>
    <div class="col-12 mt-2">
        <span class="d-block small text-muted">
            {{toDayMonthAndYearWithHour($experience->startTime(userTimezoneName()))}} to {{$experience->endTime(userTimezoneName())->format('H:i A')}} ({{userTimezoneName()}})
        </span>
    </div>
    <div class="col-12 mt-3">
        <p>{{$experience->description}}</p>
    </div>
</div>

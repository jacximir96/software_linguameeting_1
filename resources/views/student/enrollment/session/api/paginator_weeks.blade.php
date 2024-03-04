<div class="row mt-2">
    <div class="col-12 col-sm-6 offset-sm-3 d-flex justify-content-between bg-corporate-color-lighter p-1 rounded">

        @if ($paginatorPeriod->hasPrevPage ($page))
            <a href="{{route('get.student.api.session.get.coaching_week', [$course->hashId(), $coachingWeek->sessionOrderObject()->get(), ($page-1)] )}}"
               class="weekNavigator"

               title="Prev Week">
                <i class="fa fa-arrow-left fa-2x"></i>
            </a>
        @else
            <i class="fa fa-arrow-left fa-2x text-muted"></i>
        @endif

        @if ($paginatorPeriod->hasNextPage($page))
            <a href="{{route('get.student.api.session.get.coaching_week', [$course->hashId(), $coachingWeek->sessionOrderObject()->get(), ($page+1)] )}}"
               class="weekNavigator"
               title="Next Week">
                <i class="fa fa-arrow-right fa-2x"></i>
            </a>
        @else
            <i class="fa fa-arrow-right fa-2x text-muted"></i>
        @endif

    </div>
</div>

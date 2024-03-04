
<div class="row mt-0">
    <div class="col-xl-6 bg-corporate-color-light">
        <span class="fw-bold text-corporate-dark-color">
            Select the week where you want to use the extra session
        </span>
    </div>
</div>

<div class="row mt-2">
    @forelse($coachingWeeks as $coachingWeek)
        <div class="col-12 mt-3">
            <input type="radio"
                   name="coaching_week_id"
                   value="{{$coachingWeek->hashId()}}"
                   class="coaching-week-option"
                   data-start-date="{{$coachingWeek->start_date->toDateString()}}"
                   data-end-date="{{$coachingWeek->end_date->toDateString()}}"
            />
            <span class="fw-bold">
                Week {{$coachingWeek->sessionOrder()}}</span>
            <span>From {{toMonthDayYear($coachingWeek->start_date, 'UTC')}} to {{toMonthDayYear($coachingWeek->end_date, 'UTC')}}</span>
            {{$coachingWeek->hashId()}}
        </div>
    @empty
        <div class="col-12">
            <span class="text-warning-dark fw-bold">No hay semanas para seleccionar.</span>
        </div>
    @endforelse

</div>


<div class="row mt-4">
    <div class="col-12 col-xl-6">
        @include('student.enrollment.session.extra-session.search_form',[
            'isWeek' => true
        ])
    </div>
</div>



<div class="row">
    <div class="col-12">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-book"></i> Assignments</span>
    </div>
</div>

<div class="row gx-3 mt-2 small">

    @foreach ($course->coachingWeeksSortedByDate() as $coachingWeek)
        <div class="col-12 mt-2 border rounded">

            <div class="row">

                <div class="col-5 fw-bold">
                    @if ($coachingWeek->isMakeup())
                        Additional Make-Up Period
                    @else
                        Session {{$coachingWeek->session_order}}
                    @endif
                </div>
                <div class="col-7 text-end">
                    <span class="fw-bold">
                    {{$coachingWeek->start_date->format('m/d/Y')}} - {{$coachingWeek->end_date->format('m/d/Y')}}</span>
                </div>
            </div>

            @php $assignment = $coachingWeek->assignment->first() @endphp

            @if ($assignment)
                @include('assignment.mini_card_assignent', ['assignment' => $assignment])
            @else
                <div class="row mt-2">
                    <div class="col-12">
                        <span class="text-corporate-danger">No assignment selected</span>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>

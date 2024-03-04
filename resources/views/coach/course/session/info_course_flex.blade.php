<div class="row">
    <div class="col-12">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-headphones"></i> Course</span>
    </div>
</div>

<div class="row mt-2 gx-3">

    <div class="col-sm-6 ">
        <div class="row">
            <div class="col-12">
                <label class="me-3 fw-bold text-corporate-color">Name</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="fw-bold p-1" style="background-color:{{$course->color}}">{{$course->name}}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        @include('common.card_field', ['tag' => 'Start Date', 'value' => $course->start_date->format('m/d/Y')])
    </div>

    <div class="col-sm-2">
        @include('common.card_field', ['tag' => 'End Date', 'value' => $course->end_date->format('m/d/Y')])
    </div>

    <div class="col-sm-2">
        @include('common.card_field', ['tag' => 'Type Course', 'value' => $course->conversationPackage->sessionType->name])

    </div>

</div>

<div class="row gx-3 mt-2">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-12">
                <label class="me-3 fw-bold text-corporate-color">University</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{$course->university->name}}
            </div>
        </div>
    </div>
    @if ( ! $course->isFlex())
        <div class="col-sm-2">
            @include('common.card_field', ['tag' => 'Coaching Start', 'value' => $course->coachingWeeksOrdered()->first()->start_date->format('m/d/Y')])
        </div>
        <div class="col-sm-2">
            @include('common.card_field', ['tag' => 'Coaching End', 'value' => $course->coachingWeeksOrdered()->first()->end_date->format('m/d/Y')])
        </div>
    @endif
</div>

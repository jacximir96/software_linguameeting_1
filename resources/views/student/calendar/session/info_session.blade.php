<div class="row">
    <div class="col-12">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-comments"></i> Session</span>
    </div>
</div>

<div class="row gx-3 mt-2">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-12">
                <label class="me-3 fw-bold text-corporate-color">Date</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="fw-bold" style="background-color: #e4ffcb;">{{ toDate($session->startTime(), $timezone)}}</span>
                <span class="d-block small">{{$timezone->name}}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="row">
            <div class="col-12">
                <label class="me-3 fw-bold text-corporate-color">Start Time</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="fw-bold" style="background-color: #e4ffcb;">{{toTime24h($session->startTime(), $timezone)}}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="row">
            <div class="col-12">
                <label class="me-3 fw-bold text-corporate-color">End Time</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="fw-bold" style="background-color: #e4ffcb;">{{toTime24h($session->endTime()->clone()->addMinute(), $timezone)}}</span>
            </div>
        </div>
    </div>
</div>

@if (isset($enrollmentSession))
    @if ($enrollmentSession->makeup)
    <div class="row gx-3 mt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <label class="me-3 fw-bold text-corporate-color">Makeup</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <span class="d-block fw-bold" style="background-color: #e4ffcb;">Yes</span>
                </div>
                <div class="col-12">
                    <span class="d-inline-block small">{{ toDate($enrollmentSession->coachingWeek->period()->getStartDate())}}</span>
                    <span class="fst-italic">to</span>
                    <span class="d-inline-block small">{{ toDate($enrollmentSession->coachingWeek->period()->getEndDate())}}</span>

                </div>
            </div>
        </div>
    </div>
        @endif
@endif

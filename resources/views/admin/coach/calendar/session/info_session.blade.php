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

<div class="row mt-3">
    <div class="col-12 small">
        @if ($session->isBlocked())
            <span class="d-block text-corporate-danger">
                Atención, esta sesión está bloqueada.
            </span>
            <span class="d-block">
                <a href="{{route('get.calendar.session.block', $session->id)}}"
                   onclick="return confirm('Are you sure to unblock this session?');"
                   class="text-decoration-underline">
                    Desbloquear sesión
                </a>
            </span>
        @elseif(user()->hasAdminRoles())
            <a href="{{route('get.calendar.session.block', $session->id)}}"
               onclick="return confirm('Are you sure to block this session?');"
               class="text-decoration-underline">Session Block</a>
        @endif
    </div>
</div>

<div class="mt-2 text-muted">
    <span class="text-corporate-danger fw-bold">Important!</span>
</div>

<div class="mt-2 text-muted">
    <i class="fa fa-circle fa-xs text-corporate-dark-color"></i> You have <span class="text-corporate-danger fw-bold">{{$viewData->sessionsBag()->remainedSessionsCount()}}</span> sessions remaining.
</div>
<div class="mt-2 text-muted">
    <i class="fa fa-circle fa-xs text-corporate-dark-color"></i> You have missed <span class="text-corporate-danger fw-bold">{{$viewData->sessionsBag()->missedSessionsCount()}}</span> sessions.
</div>
<div class="mt-2 text-muted">
    <i class="fa fa-circle fa-xs text-corporate-dark-color"></i> You have <span class="text-corporate-danger fw-bold">{{$makeupAvailability->numMaxAvailableForPurchase()->get()}}</span> make-up session(s) available for purchase.
</div>
<div class="mt-4 text-muted">
    <i class="fa fa-circle fa-xs text-corporate-dark-color"></i> You have <span class="text-corporate-danger fw-bold">{{$makeupAvailability->numMaxAvailableForFree()->get()}}</span> free make-up session(s) available.
</div>

<div class="row mt-2">
    <div class="col-12">
        <span class="text-corporate-danger fw-bold p-1">Do you wish to select this time?</span>
    </div>
</div>

@php $moment = $coachSchedule->startTime() @endphp
<div class="row mt-3">
    <div class="col-12 ps-5">
        <span class="bg-corporate-color-light fw-bold p-1 me-3">Date:</span>
        <span class="fw-bolda p-1">{{toMonthDayAndYear($moment, $studentTimezone)}}</span>
    </div>

    <div class="col-12 ps-5 mt-3">
        <span class="bg-corporate-color-light fw-bold p-1 me-3">Hour:</span>
        <span class="fw-bolda p-1">{{toTime24h($moment, $studentTimezone)}}</span>
    </div>

    <div class="col-12 ps-5 mt-3">
        <span class="bg-corporate-color-light fw-bold p-1 me-3">Coach:</span>
        <span class="fw-bolda p-1">{{$coach->writeFullName()}}</span>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-end">

        <button class="btn btn-sm bg-corporate-color text-white fw-bold btn-bold px-4 me-3" type="submit" id="select-session-button" data-form-id="{{$formId}}">
            Yes
        </button>

        <button type="button" class="btn btn-sm btn-secondary px-4 " data-bs-dismiss="modal">No</button>


    </div>
</div>


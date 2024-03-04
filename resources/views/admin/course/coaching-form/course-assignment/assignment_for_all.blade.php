<div class="card mb-3 p-2 div-assignment-for-all {{$sectionAssignment->section()->withAssignment() ? 'd-block' : 'd-none'}}">
    <p>
        <span class="small d-block mb-2">
            <span class="fw-bold text-corporate-color">
                <i class="fa fa-stopwatch"></i> Save time!</span>
            share assignment for all sessions. Ensure dates are listed.
        </span>

        {{Form::file('assignment_for_all_'.$sectionAssignment->sectionId(), ['class' => 'form-control-xs upload-assignment upload-all-assignment', 'data-session-id' => 'all'])}}
        <span class="d-block subtitle-color small">Select the file and click the '<span class="fst-italic">Save</span>' button located at the bottom of the form.</span>

        <span
            id="feedback-error-feedback-file-session-all"
            class="feedback-file-session-all feedback-file-session text-danger small fst-italic d-block"><strong></strong></span>

    </p>
</div>

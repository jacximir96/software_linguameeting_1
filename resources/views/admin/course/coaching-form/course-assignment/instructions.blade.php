<div class="card border-0">
    <div class="card-body p-0">

        <div class="row mt-4">
            <div class="col-12">
                <span class="title-field-form "><i class="fa fa-list-ul fa-fw"></i> Instructions</span>
            </div>
        </div>

        <div class="mt-2">

            <p class="my-2">
                @if ($course->language->hasLinguameetingGuide())
                    For each session, please either select a conversation guide from the drop down menu, or create your own
                    assignment.
                @else
                    For each session please create an assignment. If you choose to upload a file, please use
                        <a href="{{$instructionsFinder->obtainCreateAssignmentInstructionsUrl()->get()}}" target="_blank">these templates</a> as a reference.
                @endif
            </p>
        </div>
    </div>
</div>

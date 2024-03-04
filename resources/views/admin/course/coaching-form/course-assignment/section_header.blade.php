<div class="row">

    <div class="col-xl-7">

        <div class="row">

            <div class="col-12 mb-1">
                <span class="small d-block">Conversation guides, choose one of the following:</span>
            </div>

            @if ($course->conversationGuide->hasBook())

                <div class="col-md-6 text-left">
                    {{Form::radio('guide_type', 'guide', $sectionAssignment->section()->withGuide(), ['class' => 'guide-type'])}} {{$course->conversationGuide->name}}
                    <span class="d-block subtitle-color fst-italic" style="font-size: 0.8rem">Default Conversation guide</span>
                </div>

            @endif

            <div class="col-md-6 text-left mt-2 mt-lg-0">
                {{Form::radio('guide_type', 'file', $sectionAssignment->section()->withAssignment(), ['class' => 'guide-type'])}} Upload assignment
                <span class="d-block subtitle-color fst-italic" style="font-size: 0.8rem">Use your custom guides.</span>
                <span class="d-block subtitle-color small" style="font-size: 0.8rem">For more specific content (<a href="https://www.dropbox.com/sh/nsm6c4gt35wtgj3/AADgxGur33W9wos5xH7eeMSra?dl=0" target="_blank">see example</a>).</span>
            </div>

        </div>

    </div>

    <div class="col-xl-5 mt-3 mt-xl-0">

        <div class="row">
            <div class="col-12 mt-0">
                <span class="small d-inline-block">Give students access for all session</span>
                {{Form::checkbox('all_students_access['.$sectionAssignment->section()->id.']', 1, null, [
                        'class' => 'form-check-input d-inline-block ms-1 give-all-students-access',
                        'data-target-class'=> 'check-student-access'])}}
            </div>
        </div>

    </div>
</div>

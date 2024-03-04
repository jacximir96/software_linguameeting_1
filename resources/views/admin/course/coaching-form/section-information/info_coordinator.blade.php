<div class="row mt-3 mt-sm-2 ">
    <div class="col-12">
        <span class="title-field-form "><i class="fa fa-user-cog fa-fw"></i> Course Coordinator</span>

        <a  href="{{route('get.common.course.course_coordinator.create', $course->id)}}"
            class="small open-modal text-success fw-bold d-inline-block ms-0 ms-sm-5 mt-2 mt-xl-0"

            data-modal-reload="yes"
            data-reload-type="parent"
            data-modal-title='Create course coordinator'>
            <i class="fa fa-plus"></i> Create Course Coordinator
        </a>
    </div>
</div>

<div class="row mt-2">

    <div class="col-md-8 col-lg-5">

        @if ($sectionInformationForm->hasCoordinators())
            {{Form::select('coordinator_id', $sectionInformationForm->optionsField('optionsCoordinators'),null, [
                            'placeholder' => 'Select Course Coordinator',
                            'id' => 'coordinator-id',
                            'data-url-assign' => route('post.admin.api.course_coordinator.assign', $course->id),
                            'data-url-remove' => route('get.admin.api.course_coordinator.remove', $course->id),
                            'class' => ' save-course-coordinator form-control form-select '.($errors->has('coordinator_id') ? ' is-invalid ' : '')],
                            )}}

            @error('language_id')

            <span class="custom-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
            @enderror
        @else
            <span class="subtitle-color">There are no course coordinators assigned</span>
        @endif
    </div>

    <div class="col-12">

    </div>
</div>

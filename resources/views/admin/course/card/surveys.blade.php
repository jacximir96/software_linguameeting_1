<div class="card mb-4 bg">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fa fa-fw fa-poll me-2"></i> Surveys
        </span>

        <a href="{{route('get.admin.survey.create', [\App\Src\CourseDomain\Course\Model\Course::MORPH, $course->id])}}"
           class="open-modal mt-1 text-success "
           data-modal-size="modal-lg"
           data-modal-reload="yes"
           data-reload-type="parent"
           data-modal-title="Create Survey"
           title="Create Survey">
            <i class="fa fa-plus"></i> Create Survey
        </a>
    </div>
    <div class="card-body">

        <div class="col-12 mb-3 ps-2 ">

            @include('admin.survey.table_summary', ['surveys' => $course->survey])
        </div>

    </div>

</div>


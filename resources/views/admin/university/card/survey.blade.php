<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-poll me-1"></i>
            Surveys
        </span>

        <a href="{{route('get.admin.survey.create', [\App\Src\UniversityDomain\University\Model\University::MORPH, $university->id])}}"
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
        @include('admin.survey.table_summary', ['surveys' => $university->survey])
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light ">
        <span class="text-corporate-dark-color fw-bold">
            <i class="fa fa-graduation-cap me-1"></i> Instructed by
        </span>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12">

                <span class="d-block colorCustomWarning">This instructor does not depend on any instructor.</span>

                <a href="{{route('get.admin.instructor.teaching_assistant.assign_instructor', $instructor->hashId())}}"
                   title="Assign instructor to {{$instructor->writeFullName()}}"
                   class="open-modal d-block mt-3"

                   data-modal-reload="yes"
                   data-reload-type="parent"
                   data-modal-title='Assign instrutor to assistant'>
                    <i class="fa fa-plus text-success"></i> Assign instructor
                </a>
            </div>
        </div>
    </div>
</div>

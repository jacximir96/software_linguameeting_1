<div class="col-12 py-2 mb-2 rounded" style="background-color: rgba(53, 180, 180,0.2)">
    <div class="row">
        <div class="col-12 text-start">
            <span class="text-corporate-dark-color fw-bold ms-2 me-3"><i class="fa fa-fw fa-chalkboard-teacher me-2"></i> Sections</span>
            <a href="{{route('get.admin.course.coaching_form.section_information', $course)}}" class="small" title="Edit sections">
                <i class="fa fa-edit"></i>
            </a>
        </div>
    </div>
</div>

@foreach ($sections as $section)
    <div class="col-12 mb-3 ps-2 small">

        <div class="row">
            <div class="col-12">
                <span class="fw-bold fst-italic">Section {{$loop->iteration}}</span>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Name</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <span class="fst-italic">{{$section->name}}</span>
                <a href="{{route('get.common.course.section.file.instructions.download', $section)}}"
                   title="Download instructions"
                   class="small d-block">
                    <i class="fa fa-download"></i> Instructions
                </a>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Instructor</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <span class="fst-italic">{{$section->instructor->writeFullName()}}</span>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-12 col-lg-4 col-xl-3">
                <span class="fw-bold text-corporate-color">Class ID</span>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <span class="fst-italic">{{$section->code}}</span>
            </div>
        </div>

    </div>
@endforeach

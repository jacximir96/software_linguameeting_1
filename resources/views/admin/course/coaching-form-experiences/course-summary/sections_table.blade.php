<div class="col-12 py-2 mb-2 rounded" style="background-color: rgba(53, 180, 180,0.2)">
    <div class="row">
        <div class="col-12 text-start">
            <span class="text-corporate-dark-color fw-bold ms-2 me-3"><i class="fa fa-fw fa-chalkboard-teacher me-2"></i> Sections</span>
            <a href="{{route('get.admin.course.coaching_form_experiences.section_information', $course->id)}}" class="small" title="Edit sections">
                <i class="fa fa-edit"></i>
            </a>
        </div>
    </div>
</div>

<table class="table table-sm table-responsive table-bordered">
    <thead>
        <tr class="text-corporate-color">
            <th class="col-5">Name</th>
            <th class="col-4">Instructor</th>
            <th class="col-2">Class ID</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sections as $section)
            <tr class="small">
                <td>
                    <span class="d-block fw-bold">{{$section->name}}</span>

                    <a href="{{route('get.common.course.section.file.instructions.download', $section->id)}}"
                       title="Download instructions"
                       class="small-font-size-08 d-block mt-2">
                        <i class="fa fa-download"></i> Student Instructions
                    </a>
                </td>
                <td>
                    {{$section->instructor->writeFullName()}}
                </td>
                <td class="text-center">
                    {{$section->code}}
                </td>
            </tr>
            @endforeach
    </tbody>
</table>

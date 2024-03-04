<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light ">
        <span class="text-corporate-dark-color fw-bold">
            <i class="fas fa-cubes me-1"></i>
            @if (isset($asAssistant))
                Instructor's sections as assistant
            @else
                Instructor's Sections
            @endif
        </span>
    </div>
    <div class="card-body  d-none d-md-block">
        <div class="table-responsive">
            <table id="" class="table table-hover">
                <thead>
                <tr class="small">
                    <th class="w-50">Name</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Lingro?</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($sections as $section)
                    <tr>
                        <td class="w-50">
                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Section</span>
                                <a href="{{route('get.admin.course.show', $section->course->hashId())}}" class="d-inline-block" title="Show detail course">
                                    {{$section->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">Course</span>
                                <a href="{{route('get.admin.course.show', $section->course->hashId())}}" class="d-inline-block ms-1" title="Show detail course">
                                    {{$section->course->name}}
                                </a>
                            </p>

                            <p class="my-0 mb-1">
                                <span class="small d-inline-block">University</span>
                                <a href="{{route('get.admin.university.show', $section->course->university->hashId())}}" class="" title="Show university">
                                    {{$section->course->university->name}}
                                </a>
                            </p>
                        </td>
                        <td>
                            {{$section->course->start_date->format('m-d-y')}}
                        </td>
                        <td>
                            {{$section->course->end_date->format('m-d-y')}}
                        </td>
                        <td>
                            {{$section->course->isLingro() ? 'Yes' : 'No'}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No sections assigned</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-responsive d-block d-md-none">
            <table id="" class="table table-hover table-responsive">
                <thead>
                <tr class="small">
                    <th>Sections</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($sections as $section)
                    <tr>
                        <td>

                            <p class="my-0">
                                <span class="d-block me-2 small text-decoration-underline fw-bold">Section</span>

                                <a href="#" class="d-inline-block" title="Show detail course">
                                    {{$section->name}}
                                </a>
                            </p>

                            <p class="my-0 mt-1">
                                <span class="d-block me-2 small text-decoration-underline">Course</span>
                                <span class="small fst-italic">
                                <a href="#" class="d-block" title="Show detail course">
                            {{$section->course->name}}
                        </a>
                            </span>
                            </p>

                            <p class="my-0 mt-1">
                                <span class="d-block me-2 small text-decoration-underline">University</span>
                                <span class="small fst-italic">
                                <a href="{{route('get.admin.university.show', $section->course->university->hashId())}}" class="text-block" title="Show university">
                                    {{$section->course->university->name}}
                                </a>
                            </span>
                            </p>

                            <p class="my-0 mt-1">
                                <span class="d-block me-2 small text-decoration-underline">Dates</span>
                                <span class="small fst-italic">
                                {{$section->course->start_date->format('m/d/Y')}} <span class="fst-italic">to</span>  {{$section->course->end_date->format('m/d/Y')}}
                            </span>
                            </p>

                            <p class="my-0 mt-1">
                                <span class="d-block me-2 small text-decoration-underline">Lingro?</span>
                                <span class="small fst-italic">
                                {{$section->course->isLingro() ? 'Yes' : 'No'}}
                            </span>
                            </p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No sections assigned</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

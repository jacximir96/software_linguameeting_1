<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-headphones me-1"></i>
            Active Courses
        </span>
    </div>
    <div class="card-body">

        <div class="table-responsive d-none d-md-block">
            <table id="" class="table table-hover ">
            <thead>
            <tr class="small">
                <th>Name</th>
                <th>Start</th>
                <th>End</th>
                <th>Lingro?</th>
            </tr>
            </thead>

            <tbody>
            @php $shows = 0 @endphp
            @forelse ($courses as $course)

                @if ( ! $course->isActive())
                    @continue
                @endif

                @php $shows++ @endphp

                @if ($shows > 5)
                    @break
                @endif

                <tr class="">
                    <td class="w-40">
                        <p class="my-0 mb-1">
                            <a href="#" class="d-inline-block "
                               title="Show detail course">
                                {{$course->name}}
                            </a>
                        </p>

                        <p class="my-0 mb-1">
                            <span class="small d-inline-block">University</span>
                            <a href="{{route('get.admin.university.show', $course->university->id)}}" class="" title="Show university">
                                {{$course->university->name}}
                            </a>
                        </p>

                    </td>
                    <td>
                        {{toDate($course->start_date)}}
                    </td>
                    <td>
                        {{toDate($course->end_date)}}
                    </td>
                    <td>
                        {{$course->isLingro() ? 'Yes' : 'No'}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <span class=" text-white bg-warning px-2 py-1 rounded ">No courses to show</span>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
            <p class="text-end">
                <a href="#" class="">Show all</a>
            </p>
        </div>

        <table id="" class="table table-hover d-md-none">
            <thead>
            <tr class="small">
                <th>Course</th>
            </tr>
            </thead>

            <tbody>
            @php $shows = 0 @endphp
            @forelse ($courses as $course)

                @if ( ! $course->isActive())
                    @continue
                @endif

                @php $shows++ @endphp

                @if ($shows > 5)
                    @break
                @endif

                <tr>
                    <td>
                        <p class="my-0">
                            <span class="d-block me-2 small  text-decoration-underline fw-bold">Course</span>
                            {{$course->name}}
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">University</span>
                            <span class="small fst-italic">
                                <a href="{{route('get.admin.university.show', $course->university->id)}}" class="d-block" title="Show university">
                                    {{$course->university->name}}
                                </a>
                            </span>
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">Dates</span>
                            <span class="small fst-italic">
                                {{toDate($course->start_date)}} <span class="fst-italic">to</span> {{toDate($course->end_date)}}
                            </span>
                        </p>

                        <p class="my-0 mt-1">
                            <span class="d-block me-2 small text-decoration-underline">Lingro?</span>
                            <span class="small fst-italic">
                                {{$course->isLingro() ? 'Yes' : 'No'}}
                            </span>
                        </p>

                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        <span class=" text-white bg-warning px-2 py-1 rounded ">No courses to show</span>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

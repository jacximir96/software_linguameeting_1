<div class="card float-none margin-top-10 card-list-courses-instructor">

    <div class="card-body">

    
        <table id="table-instructor" class="table" >
            <thead>
                <tr>
                    <th class="">COURSE NAME</th>       
                    <th>COACHING PERIOD</th>
                    <th>CREATED</th>
                    <th>REGISTERED STUDENTS</th>
                    <th>CLASS ID/INSTRUCTIONS</th>
                    <th>INSTRUCTOR</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>

                <!-- href="{{route('get.admin.course.coaching_form.create.update.academic_dates', 555)}}-->
                @forelse ($sections as $section)
                @if (!$section->course->isActive())
                <tr>

                    <td class="cursor_pointer">
                        <a class="a-title" href="{{route('get.instructor.course.show', $section->course_id)}}" title="Show course">
                            <u> {{$section->course->name}}
                            </u>
                        </a>
                    </td>
               
                    <td>
                        {{$section->course->firstDate()->format('m/d/y')}} - {{$section->course->lastDate()->format('m/d/y')}}
                    </td>

                    <td >
                        <strong>{{$section->course->created_at->format('M d, y')}}</strong>
                    </td> 

                    <td class="">{{$section->enrollment()->count()}}/{{$section->num_students}}</td>

                    <td>
                        <a class="a-title" href="{{route('get.common.course.section.file.instructions.download', $section->id)}}"><u>{{$section->code}}</u></a>
                    </td>
                    <td>{{$section->instructor->writeFullName()}}</td>
                    <td>
                        <select class="form-select form-select-sm actionsChange" aria-label=".form-select-sm example">
                            <option value="">Actions </option>
                            <option value="{{route('get.instructor.course.show', $section->course_id)}}">See course information</option>
                            <option value="{{route('get.common.course.section.file.instructions.download', $section->id)}}">Download Instructions</option>
                            <option value="">Download attendance report</option>
                        </select>

                    </td>

                </tr>
                @endif
                @empty
                    <tr>
                        <td>
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No past courses</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

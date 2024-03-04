<div class="row">
    <div class="col-12">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-cubes"></i> Sections</span>
    </div>
</div>

<div class="row gx-3 mt-2">
    <table id="" class="table table-hover">
        <thead>
        <tr>
            <th class="w-50">Section</th>
            <th>Instructor</th>
        </tr>
        </thead>

        <tbody>
        @php $sections = $course->section->sortBy(function ($section){return $section->name;}) @endphp
        @forelse ($sections as $section)
            <tr>
                <td>{{$section->name}}</td>
                <td>
                    {{$section->instructor->writeFullName() ?? '-'}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2">This course has not sections.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

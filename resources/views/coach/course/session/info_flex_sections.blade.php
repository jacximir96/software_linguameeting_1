<div class="row">
    <div class="col-12">
        <span class="d-block p-1 bg-corporate-color-light text-corporate-dark-color fw-bold"><i class="fa fa-cubes"></i> Sections</span>
    </div>
</div>

<div class="row mt-2 small">

    @php $sections = $course->section->sortBy(function ($section){return $section->name;}) @endphp
    @forelse ($sections as $section)

        <div class="col-12 mt-2">
            <div class="row border rounded gx-0 p-2">

                <div class="col-4">

                    <div class="row">
                        <div class="col-12">
                            @include('common.card_field', ['tag' => 'Name Section', 'value' => $section->name])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @include('common.card_field', ['tag' => 'Instructor', 'value' => $section->instructor->writeFullName() ?? '-'])
                        </div>
                    </div>

                </div>

                <div class="col-8">
                    @foreach ($section->assignments() as $assignment)
                        <div class="col-12 mt-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="row">
                                <div class="col-5 fw-bold">
                                    Session {{$assignment->session_order}}
                                </div>
                            </div>

                            @if ($assignment)
                                @include('assignment.mini_card_assignent', ['assignment' => $assignment])
                            @else
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <span class="text-corporate-danger">No assignment selected</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @empty
        <p class="text-corporate-danger">
            No assignments found
        </p>
    @endforelse




</div>

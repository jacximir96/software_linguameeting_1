<div class="card mb-4 bg">
    <div class="card-header d-flex justify-content-between  bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-cubes me-1"></i>
            Sections
        </span>
    </div>
    <div class="card-body d-none d-md-block">

        @forelse ($sections as $section)

            <div class="row border-bottom pb-2 mb-2">
                <div class="col-12">

                    <div class="row">
                        <div class="col-4">
                            @include('common.card_field', ['tag' => 'Name', 'value' => $section->id .' - '.$section->name, 'valueIsBold' => true])
                        </div>
                        <div class="col-4">
                            @include('common.card_field_tag', ['tag' => 'Instructor'])
                            <div class="row">
                                <div class="col-12">
                                    @if ($section->instructor)
                                        <span class="{{isset($valueIsBold) ? 'fw-bold' : ''}}">
                                            <a href="#"> {{$section->instructor->writeFullName()}}</a>
                                        </span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="me-3 fw-bold text-corporate-color">Students by class</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <span class="">{{$section->num_students}}</span> / <span class="" title="Enrollment">{{$section->enrollment()->count()}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            @include('common.card_field', ['tag' => 'ID/Register URL ', 'value' => $section->code])
                        </div>

                        <div class="col-4">
                            @include('common.card_field', ['tag' => 'Lingro Code', 'value' => $section->lingro_code ?? '-'])
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-3">
                            <a href="{{route('get.common.course.section.file.instructions.download', $section->id)}}"
                               title="Download instructions"
                               class="small-font-size-08">
                                <i class="fa fa-download"></i> Student Instructions
                            </a>
                        </div>

                        <div class="col-3">
                            <a href="{{route('get.admin.course.section.documentation.send.show_log', $section->id)}}"
                               title="Send Documentation"
                               class="small-font-size-08 me-3 open-modal"
                               data-modal-size="modal-lg"
                               data-modal-reload="no"
                               data-modal-title='Section documentation submission log'>
                                <i class="fa fa-envelope"></i> Send Documentation
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        @empty
            <div class="row border-bottom pb-2 mb-2">
                <div class="col-12">
                    <span class=" text-white bg-warning px-2 py-1 rounded ">No sections assigned</span>
                </div>
            </div>
        @endforelse
    </div>
</div>

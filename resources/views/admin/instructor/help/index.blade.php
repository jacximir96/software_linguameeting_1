@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-question-circle me-1"></i>
                Help
            </span>

            <a href="{{route('get.admin.instructor.help.create')}}"
               title="Create Help Article"
               class="open-modal mt-1 text-success "
               data-modal-size="modal-lg"
               data-modal-reload="yes"
               data-reload-type="parent"
               data-modal-title="Create Help Article">
                <i class="fa fa-plus"></i> Create Help Article
            </a>
        </div>
        <div class="card-body col-12 ">

            @php $typeId = null; $cont = 1; @endphp
            @foreach ($helps as $help)

                @if ($help->instructor_help_type_id != $typeId)
                    @php $typeId = $help->instructor_help_type_id; $cont = 1; @endphp
                    <div class="col-row mt-3">
                        <div class="col-12 bg-corporate-color-light rounded p-1 fw-bold">
                            {{$help->type->name}}
                        </div>
                    </div>
                @endif

                <div class="row mt-2">
                    <div class="col-12 ps-4">
                        <a href="{{$help->url}}" target="_blank" class="me-3" title="Go to {{$help->description}}">
                            <span class="text-dark">{{$cont}}.</span> <span>{{$help->description}}</span>
                        </a>

                        <a href="{{route('get.admin.instructor.help.edit', $help->id)}}"
                           title="Edit Help"
                           class="open-modal me-2 text-primary "
                           data-modal-size="modal-lg"
                           data-modal-reload="yes"
                           data-reload-type="parent"
                           data-modal-title="Edit Help">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="{{route('get.admin.instructor.help.delete', $help->id)}}"
                           onclick="return confirm('Are you sure you want to delete this help?');"
                           class="text-danger"
                           title="Delete Help">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                @php $cont++ @endphp
            @endforeach
        </div>
    </div>
@endsection

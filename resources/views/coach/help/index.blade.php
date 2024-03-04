@extends('layouts.app')

@section('content')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-question-circle me-1"></i>
                Help
            </span>

        </div>
        <div class="card-body col-12 ">

            @php $typeId = null; $cont = 1; @endphp
            @foreach ($helps as $help)

                @if ($help->coach_help_type_id != $typeId)
                    @php $typeId = $help->coach_help_type_id; $cont = 1; @endphp
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
                    </div>
                </div>
                @php $cont++ @endphp
            @endforeach
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<div class="card mb-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4" style="color: #39b4b3;"><i class="fas fa-info-circle"></i> Help</h4>
                    @php $counter = 1; @endphp
                    @foreach($instructorHelpTypes as $type)
                        <div class="card shadow mb-3">
                            <div class="card-header" style="background-color: #39b4b3; color: white;">
                                <h5 class="mb-0"><i class="fas fa-layer-group"></i> Tipo {{ $counter }}: {{ $type->name }}</h5>
                            </div>
                            <div class="card-body">
                                @if($type->helps->isNotEmpty())
                                    <ul class="list-group list-group-flush">
                                        @foreach($type->helps as $help)
                                            <li class="list-group-item">
                                                <i class="far fa-hand-point-right mr-2"></i> {{ $help->description }}
                                                <a href="{{ $help->url }}"  target="_blank"  class="btn btn-outline-primary btn-sm float-right"><i class="fas fa-external-link-alt"></i> Ver Más</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted"><i class="fas fa-times-circle mr-2"></i> No hay ayudas disponibles para este tipo.</p>
                                @endif
                            </div>
                        </div>
                        @php $counter++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
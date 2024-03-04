@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search Coaches</h6>
        </div>
        <div class="card-body">
            @include('admin.coach.ranking.search_form')
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-sort-numeric-up-alt me-1"></i>
                Ranking
            </span>
        </div>
        <div class="card-body">

            <p>Selecciona lenguaje para mostrar el ranking.</p>

        </div>
    </div>

@endsection

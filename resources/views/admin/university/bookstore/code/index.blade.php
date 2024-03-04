@extends('layouts.app')

@section('content')

    @include('admin.university.bookstore.shared.search_form')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-table me-1"></i>
                List of codes
            </span>
            <div>
                @include('admin.university.bookstore.shared.create_links')
            </div>
        </div>
        <div class="card-body">
            @include('admin.university.bookstore.code.table_codes', ['codes' => $codes])

        </div>
    </div>
@endsection

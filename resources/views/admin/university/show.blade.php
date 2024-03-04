@extends('layouts.app')

@section('content')


    <div class="row my-3">

        <div class="col-xl-5">

            <div class="row">
                <div class="col-12">
                    @include('admin.university.card.basic_data')
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    @include('admin.university.card.survey')
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    @include('admin.university.card.experience')
                </div>
            </div>


        </div>

        <div class="col-xl-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
                <span class="">
                    <i class="fas fa-graduation-cap me-1"></i>
                    Active courses
                </span>
                </div>
                <div class="card-body">

                    @include('admin.course.table_mini_summary', ['courses' => $viewData->courses()])

                    <div class="mt-3 text-end">
                        <a href="{{route('post.admin.course.search', ['from_url' => true, 'university_id' => $viewData->university(), 'status' => 'active'])}}" class="small me-3">Show actives</a>
                        <a href="{{route('post.admin.course.search', ['from_url' => true, 'university_id' => $viewData->university()])}}" class="small">Show all</a>
                    </div>


                </div>
            </div>
        </div>
    </div>


@endsection

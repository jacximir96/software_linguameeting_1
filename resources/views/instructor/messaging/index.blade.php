@extends('layouts.app')

@section('content')

    <?php /*
    <div class="card my-3">
        <div class="card-header d-flex flex-row align-items-center justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <h6 class="m-0 font-weight-bold"><i class="fa fa-search"></i> Search instructors</h6>
        </div>
        <div class="card-body">
            @include('admin.instructor.search_form')
        </div>
    </div>
 */ ?>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-envelope me-1"></i>
                Messaging
            </span>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 col-xl-10">

                    @include('messaging.thread_tabla', ['threads' => $threads, 'user' => $instructor])

                </div>
            </div>
        </div>
    </div>
@endsection

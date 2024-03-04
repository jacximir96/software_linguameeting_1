@extends('layouts.app')

@section('content')

    <div class=" mt-3">

        @if ($enrollments->count())

            <div class="row">
                <div class="col-12">
                    <h5 class="fw-bold text-corporate-danger text-decoration-underline">
                        Past Courses
                    </h5>
                </div>
            </div>

            <div class="row justify-content-center mt-4">

            @foreach ($enrollments as $enrollment)

                <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                    <div class="card w-100 pb-5">

                        <div class="card-body d-flex flex-column">
                            @include('student.dashboard.info_enrollment', ['enrollment' => $enrollment])
                        </div>
                    </div>
                </div>

            @endforeach
            </div>
        @else

            <div class="row">
                <div class="col-12 col-xl-4 mt-0">
                    <p class="alert bg-corporate-color-light fw-bold">
                        You do not have past courses to view
                    </p>
                </div>
            </div>

        @endif

    </div>
@endsection

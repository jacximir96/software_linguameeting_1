@extends('layouts.app_modal')

@section('content')

    <div class="row d-flex">

        <div class="col-md-5">
            @include('admin.student.enrollment.info_course', ['enrollment' => $viewData->enrollment()])

            @include('admin.student.enrollment.info_enrollment', ['payment' => $viewData->payment()])

            @include('admin.student.enrollment.info_extra_sessions', ['enrollment' => $viewData->enrollment()])
        </div>

        <div class="col-md-7">
            @include('admin.student.enrollment.info_sessions', ['enrollmentSessions' => $viewData->enrollment()->enrollmentSession])
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 text-end">
            <a href="{{route('get.admin.enrollment.delete', $enrollment->id)}}"
               title="Delete this enrollment and all its related data"
               class="btn btn-danger bg-corporate-danger btn-sm"
               onclick="return confirm('Are you sure you want to delete this enrollment?');">
                Delete
            </a>
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('content')

    @include('user.row_status', ['user' => $viewData->student()])


    <div class="row my-3">
        <div class="col-xl-6">
            @include('admin.student.card.personal_data',[
                'instructor' => $viewData->student()
            ])

            @include('user.activity.activity_card', [
                'activity' => $viewData->activity(),
                'user' => $viewData->student()
               ])
        </div>

        <div class="col-xl-6">
            @include('admin.student.card.enrollments', [
                'enrollments' => $viewData->student()->enrollmentDesc
            ])
        </div>
    </div>


@endsection

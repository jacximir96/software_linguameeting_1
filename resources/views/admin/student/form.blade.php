@extends('layouts.app')

@section('content')

    <div class="card my-3">
        <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="">
                <i class="fas fa-edit me-1"></i>
                @if ($form->isCreate())
                    Create New Student
                @else
                    Edit Student
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="sbp-preview">
                <div class="sbp-preview-content">

                    @include('common.form_message_errors')

                    @if ($form->isEdit())
                        @include('user.row_status', ['user' => $student])
                    @endif

                    {{ Form::model($form->model(),  [
                   'class' => '',
                   'url'=> $form->action(),
                   'autocomplete' => 'off',
                   'id' =>'student-form',
                   'files' => false,
                   ]) }}

                    @if (isset($student))
                        @include('user.row_locked', ['user' => $student])
                    @endif

                    <div class="row">

                        <div class="col-12 col-xl-6">
                            @include('admin.student.form.personal_data')

                            <div class="row mt-5">
                                <div class="col-12 text-left">
                                    <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                                        {{$form->isCreate() ? 'Create' : 'Update'}}
                                    </button>
                                </div>
                            </div>

                            @if ($form->isEdit())
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <a href="{{route('get.admin.student.show', $student->hashId())}}">
                                            <i class="fa fa-eye text-primary"></i> Show
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

@endsection

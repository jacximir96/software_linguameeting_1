@extends('layouts.app')

@section('content')

    <div class="card my-3">
        <div class="card-header d-flex justify-content-between bg-text-corporate-color text-white">
            <span class="">
                <i class="fas fa-edit me-1"></i>
                @if ($form->isCreate())
                    Create New Coach
                @else
                    Edit Coach
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="sbp-preview">
                <div class="sbp-preview-content">

                    @include('common.form_message_errors')

                    {{ Form::model($form->model(),  [
                   'class' => '',
                   'url'=> $form->action(),
                   'autocomplete' => 'off',
                   'id' =>'coach-form',
                   'files' => true,
                   ]) }}

                    @if (isset($coach))
                        @include('user.row_locked', ['user' => $coach])
                    @endif

                    <div class="row">

                        <div class="col-12 col-xl-8">
                            @include('admin.coach.form.personal_data')

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
                                        <a href="{{route('get.admin.coach.show', $coach->hashId())}}">
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

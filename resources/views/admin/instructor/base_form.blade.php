@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
       'class' => '',
       'url'=> $form->action(),
       'autocomplete' => 'off',
       'id' =>'coordinator-form'
   ]) }}


    <div class="row mt-3">
        <div class="col-12">
            @include('common.form-field.text', ['field' => 'name', 'label' => 'Name', 'titleFieldform' => true, 'required' => true])
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            @include('common.form-field.text', ['field' => 'lastname', 'label' => 'Last name', 'titleFieldform' => true, 'required' => true])
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            @include('common.form-field.email', ['field' => 'email', 'label' => 'Email', 'titleFieldform' => true, 'required' => true])
        </div>
    </div>

    @if (isset($withRoleOptions) AND $withRoleOptions)
    <div class="row mt-3">
        <div class="col-12">

            <div class="form-group row">
                <div class="col-12 text-600 fw-bold">
                    Roles
                </div>
                <div class="col-12 mt-2">

                    <div class="row">

                        @foreach ($form->roleOptions() as $role)
                            <div class="col-4">
                                {{Form::radio('role_id', $role->id, null, ['id' => '', 'class'=>''])}} {{$role->name}}
                            </div>
                        @endforeach
                    </div>

                    @error('role_id')
                    <div class="row mt-2">
                        <div class="col-12">
                            <span class="custom-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        </div>
                    </div>
                    @enderror


                </div>
            </div>

        </div>
    </div>
    @endif
    <div class="row mt-3">
        <div class="col-12 text-end">
            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                Save
            </button>
        </div>
    </div>
    {{Form::close()}}

@endsection

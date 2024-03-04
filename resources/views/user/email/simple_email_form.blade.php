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
                @include('common.form-field.text', ['field' => 'subject', 'label' => 'Subject', 'required' => true])
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <label class="fw-bold small" for="body">Body</label>
                {!! Form::textarea('body',null,['id'=>'ckeditor', "class"=>"form-control ckeditor-basic","size"=>"30x3", 'required' => true]) !!}
                @error('body')
                    <span class="custom-invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <input type="hidden" name="users_ids" value="{{$usersIds->implode('-')}}" />
        <input type="hidden" name="users_filters" value="{{$usersFilters}}" />

        <div class="row mt-3">
            <div class="col-12 text-end">
                <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                    Send
                </button>
            </div>
        </div>
    {{Form::close()}}

@endsection

@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'chapter-form',
      'files' => true,
   ]) }}

    <div class="row mt-3">
        <div class="col-12 col-sm-6">
            @include('common.form-field.text', ['field' => 'name', 'label' => 'Name', 'min' => 1])
        </div>
    </div>

    @if ($form->isEdit())
        <div class="col-12 mt-3">
            <div class="container">
                <div class="row">
                    @if ($chapter->file)

                        <div class="col justify-content-start">
                            <a href="{{route('get.common.conversation_guide.chapter.file.download', $chapter->file->id)}}" title="Download {{$chapter->file->original_name}}">
                                <i class="fa fa-download"></i> Download
                            </a>
                        </div>
                        <div class="col-12 mt-2 fw-bold">
                            <input type="checkbox" name="delete_file" value="1"/> Delete file
                        </div>

                    @else
                        <div class="col-12 mt-2 text-danger">
                            Este tema no tiene archivo.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="col-12 mt-3">
        {{Form::file('chapter_file', ['class' => ''])}}

        @error('chapter_file')
        <span class="custom-invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>


    <div class="row mt-3">
        <div class="col-12 text-end">
            <button class="btn btn-primary btn-sm btn-bold px-4" type="submit">
                Save
            </button>
        </div>
    </div>
    {{Form::close()}}

@endsection

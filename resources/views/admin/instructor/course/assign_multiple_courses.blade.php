@extends('layouts.app_modal')

@section('content')

    @include('common.form_message_errors')

    {{ Form::model($form->model(),  [
   'class' => '',
   'url'=> $form->action(),
   'autocomplete' => 'off',
   'id' =>'assign-multiple-courses-form'
   ]) }}

    @error('course_id')
        <span class="custom-invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

        <div class="row mt-3">
            <div class="col-12">

                @php $lastUniversityId = 0 @endphp
                @foreach ($form->coursesOptions() as $course)

                    @if ($course->university->id != $lastUniversityId)
                        <div class="mb-2">
                             <span class="fw-bold">
                                {{$course->university->name}}
                            </span>
                        </div>
                        @php $lastUniversityId = $course->university->id @endphp
                    @endif

                    <div class="ps-4 mb-1">
                        {{Form::checkbox('course_id[]', $course->id, null, ['class'] )}} {{$course->name}}
                    </div>

                @endforeach
            </div>
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

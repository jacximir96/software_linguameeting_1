@extends('layouts.app')

@section('content')



    <div class="row mt-3 ">

        <div class="col-12 col-xl-4 offset-xl-4">

            @include('common.form_message_errors')

            {{ Form::model([],  [
               'class' => '',
               'url'=> route('post.student.enrollment.additional.code'),
               'autocomplete' => 'off',
               'id' =>'new-course-form',
           ]) }}


            <div class="row">
                <div class="col-12">
                    <span class="fw-bold text-corporate-dark-color h5">Registration for a new course</span>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 fw-bold">
                    Please, enter the Class ID for a new course
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <input id="code"
                           type="text"
                           name="code"
                           value="{{ old('code') }}"
                           class="form-control @error('code') is-invalid @enderror"
                           required
                           autocomplete="code" autofocus>

                    @error('code')
                    <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 text-end">
                    <button class="btn bg-corporate-color text-white btn-sm px-4" type="submit">
                        Continue
                    </button>
                </div>
            </div>
        </div>


        {{Form::close()}}

    </div>

@endsection

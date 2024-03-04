@extends('layouts.app')

@section('content')


    <div class="card my-3">
        <div class="card-header p-2 d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
            <span class="fw-bold">
                <i class="fas fa-edit me-1"></i>
                @if ($form->isCreate())
                    Coaching Form
                @endif
            </span>
        </div>
        <div class="card-body">

            @include('common.form_message_errors')

            {{ Form::model($form->model(),  [
           'class' => '',
           'url'=> $form->action(),
           'autocomplete' => 'off',
           'id' =>'coaching-form'
           ]) }}

            <div class="row">

                <div class="col-12">
                    <h5 class="text-corporate-dark-color fw-bold">
                        Select your University/School
                    </h5>
                </div>


                <div class="col-12 col-md-6 col-xl-4 mt-1 mb-3">
                    {{Form::select('university_id', $form->optionsField('universityOptions'), null,
                               [
                                   'class'=>'form-control form-select load-child-dropdown '. ($errors->has('university_id') ? 'is-invalid' : null),
                                   'data-child-dropdown-id' => 'course_id',
                                   'data-child-load-url' => '/admin/api/options/course/belong-to-university',
                                   'data-child-placeholder' => 'Select a course',
                                   'placeholder' => 'Select University',
                                   'id' => 'university_id',
                               ])}}
                    @error('university_id')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="row mt-4">

                <div class="col-12">
                    <h5 class="text-corporate-dark-color">
                        A. Select a service for your course
                    </h5>
                </div>

            </div>

            <div class="row ps-2">
                <div class="col-12 col-lg-10 col-xl-4 rounded p-2" style="border:1px solid #dee2e6">

                    <div class="row ">

                        <div class="col-6 col-sm-4 col-md-3 col-xl-3 d-flex align-items-center justify-content-start justify-content-md-center">
                            <img src="{{asset('assets/img/logo.png')}}" class="img-fluid w-70 d-block d-md-none" alt="Icon LinguaMeeting Conversations"/>
                            <img src="{{asset('assets/img/logo.png')}}" class="img-fluid w-50 d-none d-md-block" alt="Icon LinguaMeeting Conversations"/>
                        </div>

                        <div class="col-6 col-sm-4 col-md-6 col-xl-6 pt-2">
                            <span class="d-block text-decoration-underline text-dark h6" style="text-decoration-color:#39b4b3  !important;">
                                LinguaMeeting Conversations
                            </span>
                            <span class="d-block text-muted small">
                                With Native Speakers
                            </span>
                        </div>


                        <div class="col-12 col-sm-4 col-md-3 col-xl-3 text-center d-flex align-items-center justify-content-center mt-4 mt-sm-0">
                            <button type="submit"
                                    name="action"
                                    value="conversations"
                                    title="Create Course LinguaMeeting Conversations"
                                    class="btn btn-sm py-0 px-2 shadow-sm"
                                    style="border:1px solid #dee2e6">
                                <i class="fa fa-chevron-right text-corporate-color-lighter h1 p-0 m-0"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ps-2 mt-3">
                <div class="col-12 col-lg-10 col-xl-4 rounded p-2" style="border:1px solid #dee2e6">

                    <div class="row">

                        <div class="col-6 col-sm-4 col-md-3 col-xl-3 d-flex align-items-center justify-content-start justify-content-md-center">
                            <img src="{{asset('assets/img/logo_experiences.png')}}" class="img-fluid w-70 d-block d-md-none" alt="Icon Live Experiences"/>
                            <img src="{{asset('assets/img/logo_experiences.png')}}" class="img-fluid w-50 d-none d-md-block" alt="Icon Live Experiences"/>

                        </div>

                        <div class="col-6 col-sm-4 col-md-6 col-xl-6 pt-2">
                            <span class="d-block text-decoration-underline text-dark h6" style="text-decoration-color:#39b4b3  !important;">
                                Live Experiences
                            </span>
                            <span class="d-block text-muted small">
                                with LinguaMeeting Coaches
                            </span>
                        </div>

                        <div class="col-12 col-sm-4 col-md-3 col-xl-3 text-center d-flex align-items-center justify-content-center mt-4 mt-sm-0">
                            <button type="submit"
                                    name="action"
                                    value="live-experiences"
                                    title="Create Course Live Experiences"
                                    class="btn btn-sm py-0 px-2 shadow-sm"
                                    style="border:1px solid #dee2e6">
                                <i class="fa fa-chevron-right text-corporate-color-lighter h1 p-0 m-0"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ps-2 mt-3">
                <div class="col-12 col-lg-10 col-xl-4 rounded p-2" style="border:1px solid #dee2e6">

                    <div class="row">
                        <div class="col-6 col-sm-4 col-md-3 col-xl-3 d-flex align-items-center justify-content-start justify-content-md-center">
                            <img src="{{asset('assets/img/logo_experiences_combined.png')}}" class="img-fluid w-70 d-block d-md-none" alt="Icon LinguaMeeting + Experiences "/>
                            <img src="{{asset('assets/img/logo_experiences_combined.png')}}" class="img-fluid w-50 d-none d-md-block" alt="Icon LinguaMeeting + Experiences "/>
                        </div>

                        <div class="col-6 col-sm-4 col-md-6 col-xl-6 pt-2">
                            <span class="d-block text-decoration-underline text-dark h6" style="text-decoration-color:#39b4b3  !important;">
                                LinguaMeeting + Experiences
                            </span>
                            <span class="d-block text-muted small">
                                Combined Programas
                                 <a href=""
                                    class="ms-2 text-dark"
                                    data-bs-toggle="modal"
                                    data-bs-target="#info-linguameeting-experiences"
                                    title="More info">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                            </span>
                        </div>

                        <div class="col-12 col-sm-4 col-md-3 col-xl-3 text-center d-flex align-items-center justify-content-center mt-4 mt-sm-0">
                            <button type="submit"
                                    name="action"
                                    value="combined"
                                    title="Create Course LinguaMeeting + Experiences"
                                    class="btn btn-sm py-0 px-2 shadow-sm"
                                    style="border:1px solid #dee2e6">
                                <i class="fa fa-chevron-right text-corporate-color-lighter h1 p-0 m-0"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <h5 class="text-corporate-dark-color">
                        B. Edit an existing form
                    </h5>
                </div>

                <div class="mb-3 col-md-3">
                    {{Form::select('course_id', $form->optionsField('courseOptions'), null, ['id' => 'course_id', 'class'=>'form-control form-select '. ($errors->has('course_id') ? 'is-invalid' : null), 'placeholder' => ''])}}
                    @error('course_id')
                        <span class="custom-invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 text-left">
                    <button class="btn  btn-sm btn-bold px-4 bg-text-corporate-color text-white" type="submit">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                </div>
            </div>

            {{Form::close()}}

        </div>
    </div>

    @include('common.modal_info', [
       'modalId' => 'info-linguameeting-experiences',
       'modalTitle' => 'LinguaMeeting + Experiences',
       'path' => 'admin.course.coaching-form.info_linguameeting_experiences'
   ])
@endsection

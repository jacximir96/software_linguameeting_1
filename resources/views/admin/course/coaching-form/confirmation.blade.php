@extends('layouts.app')

@section('content')

    <div class="row mt-5">

        <div class="col-12">

            <div class="card">

                <div class="card-header bg-corporate-color text-white text-left">
                    <h3>{{$course->university->name}}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center mt-5">

                                <h3 class="text-corporate-dark-color">Confirmation Sent!</h3>

                                <h5 class="text-corporate-color mt-5">Check your email.</h5>
                        </div>
                        <div class="col-12 text-center mt-2">
                            <p>
                                Please review your course before submitting. You will receive email confirmation upon completion.
                            </p>
                            <p class="mt-2">
                                If you do not receive an email check your spam folder or
                                contact <a href="mailto:support@linguameeting.com">support@linguameeting.com</a>.
                            </p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2  col-xl-4 offset-xl-4 text-center mt-5 d-sm-flex justify-content-sm-between">

                            @if (user_is_admin())
                                <a href="{{route('get.admin.course.coaching_form.create.zero_step')}}"
                                   title="Add more course"
                                   class="text-corporate-dark-color text-decoration-underline d-block d-sm-inline ">
                                    <i class="fa fa-plus"></i> Add more courses
                                </a>
                                <a href="{{route('get.admin.course.index')}}"
                                   title="Show course list"
                                   class="text-corporate-dark-color text-decoration-underline d-block d-sm-inline mt-4 mt-sm-0">
                                    <i class="fa fa-eye"></i> See my active courses
                                </a>
                            @elseif(user()->isInstructor())

                                <a href="{{route('get.instructor.coaching_form.zero_step')}}"
                                   title="Add more course"
                                   class="text-corporate-dark-color text-decoration-underline d-block d-sm-inline ">
                                    <i class="fa fa-plus"></i> Add more courses
                                </a>
                                <a href="{{route('get.instructor.course.index')}}"
                                   title="Show course list"
                                   class="text-corporate-dark-color text-decoration-underline d-block d-sm-inline mt-4 mt-sm-0">
                                    <i class="fa fa-eye"></i> See my active courses
                                </a>


                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

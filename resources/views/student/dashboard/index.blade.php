@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{route('get.student.enrollment.additional.code')}}" class="bg text-corporate-dark-color fw-bold h5">
                    <i class="fa fa-plus"></i> Add New Course
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-3">

        @if ($enrollments->count())

            @foreach ($enrollments as $enrollment)

                <div class="row justify-content-center mt-4">

                    <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                        <div class="card w-100 pb-5">

                            <div class="card-body d-flex flex-column">
                                @include('student.dashboard.info_enrollment', ['enrollment' => $enrollment])
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3 d-flex align-items-stretch">
                        <div class="card w-100 pb-5">
                            <div class="card-body d-flex flex-column">
                                @if ($enrollment)
                                    @include('student.dashboard.experience', ['enrollment' => $enrollment])
                                @endif

                                @if ($experiencesRegisters->count())
                                    @foreach ($experiencesRegisters as $experienceRegister)
                                        @if ($experienceRegister->experience->isFuture($nowUTC))
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <span class="d-block fw-bold">Upcoming</span>
                                                    <span class="text-corporate-dark-color"> {{$experienceRegister->experience->title}}</span>
                                                    <a href="{{route('get.experience.register.delete', $experienceRegister->experience->hashId())}}"
                                                       onclick="return confirm('Are you sure to remove your assitence to this experience?');">
                                                        <i class="fa fa-times text-danger"></i>
                                                    </a>
                                                    <span class="d-block">
                                                 {{toDayDateTimeString($experienceRegister->experience->start, $experienceTimezone) }}
                                                to
                                                {{toTime24h($experienceRegister->experience->end, $experienceTimezone)}} ({{$experienceTimezone->name}})
                                            </span>

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        @endif

    </div>
@endsection

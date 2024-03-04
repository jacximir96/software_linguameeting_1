<div class="row">
    <div class="col-12">
        <div class="card p-3">

            <div class="row mt-4">
                <div class="col-12 text-center text-corporate-color">
                    <span class="d-block h5">{{$course->name}}</span>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12 text-center text-corporate-color">
                    <span class="d-block h5">{{$course->semester->name}}, {{$course->year}}</span>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12 text-center text-corporate-color">
                    Prof. {{$section->instructor->writeFullName()}}
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center subtitle-color">
                    <span class="h5">
                        {{$course->start_date->format('m/d/Y')}} - {{$course->end_date->format('m/d/Y')}}
                    </span>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6 col-lg-4 text-center">
                    <div class="cicleSessions">{{$course->conversationPackage->sessionType->code}}</div>
                    <div class="circleText text-16 text_center">
                        {{$course->conversationPackage->sessionType->name}}
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 text-center mt-4 mt-sm-0">
                    <div class="cicleSessions">
                        {{$course->conversationPackage->number_session}}
                    </div>
                    <div class="circleText text-16 text_center">
                        Sessions
                    </div>
                </div>
                <div class="col-lg-4 text-center mt-4 mt-md-0">
                    <div class="cicleSessions">
                        {{$course->conversationPackage->duration_session}}
                    </div>
                    <div class="circleText text-16 text_center">
                        Minutes
                    </div>
                </div>
            </div>

            @if ($course->serviceType->isCombined())
                <div class="row mt-4">

                    <div class="col-12 text-center text-corporate-color h2">
                        LinguaMeeting + Experiences
                    </div>

                </div>
            @endif
            <div class="row mt-4">

                <div class="col-12 text-center text-corporate-color h5">
                    {{$course->university->name}}
                </div>
                <div class="col-12 text-center text-deep-black ">
                    {{$course->university->country->name}} - {{$course->university->timezone->name}}
                </div>
            </div>

            <div class="row mt-5">

                <div class="col-12 py-2 mb-2 rounded bg-corporate-color-light" style="background-color: rgba(53, 180, 180,0.2)">
                    <div class="row">
                        <div class="col-6 col-md-7 col-lg-6 text-start ">
                            <span class="text-corporate-dark-color fw-bold">Price per student</span>
                        </div>
                        <div class="col-6 col-md-5 col-lg-6">
                            <span class="fst-italic fw-bold">{{$linguaMoney->format($course->price())}}</span>

                            @if( $course->hasDiscount())
                                <span class="fst-italic fw-bold">(applied discount -{{$linguaMoney->format($course->discount)}})</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

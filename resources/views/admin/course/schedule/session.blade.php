<div class="row text-start">

    <div class="col-sm-5">
        <div class="row">
            <div class="col-12">
                <span class="text-corporate-dark-color fw-bold bg-corporate-color-lighter p-1 rounded ">Coach</span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4">
                <i class="fa fa-user fa-4x"></i>
            </div>

            <div class="col-sm-8">

                <a href="{{route('get.admin.coach.show', $session->coach()->id)}}" target="_blank" class="mr-2" title="Show coach">
                    {{$session->coach()->writeFullName()}}
                </a>
                <span class="d-block">
                    <img src="{{asset('assets/img/flags/'.$session->coach()->country->flagFile())}}"
                         title="Flag of {{$session->coach()->country->name}}"
                         class="img-thumbnail flag-icon-25 me-20" />
                    {{$session->coach()->country->name}}
                </span>
            </div>

        </div>
    </div>

    <div class="col-sm-7">
        <div class="row">
            <div class="col-12">
                <span class="text-corporate-dark-color fw-bold bg-corporate-color-lighter p-1 rounded ">Students</span>
            </div>
        </div>
        <div class="row mt-2 text-start">

            @foreach ($session->enrollments() as $enrollmentSession)
                <div class="col-12">
                    <p class="ps-2">
                        <a href="#">
                            <a href="{{route('get.admin.student.show', $enrollmentSession->enrollment->student_id)}}" target="_blank" class="mr-2" title="Show student">
                                {{$enrollmentSession->enrollment->user->writeFullName()}}
                            </a>
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>

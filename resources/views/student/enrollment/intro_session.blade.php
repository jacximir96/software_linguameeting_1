<div class="row">

    <div class="col-12">


        <img src="{{asset('assets/img/logo_solo.png')}}" class="w-5"/>

        <span class="bg-corporate-color-light text-corporate-dark-color fw-bold p-1 rounded">
            INTRO SESSION
        </span>
        <span class="fw-bold d-inline-block ms-2">
            This session will serve as a guide for course program this semester.
        </span>

        @if ( ! $enrollment->hasIntroSession ())

            <a href="https://www.dropbox.com/s/m38zr0ecbo8jtvn/Video%20de%20la%20misión%20del%20coach%202022.mp4"
               target="_blank"
               data-url-intro="{{route('get.student.session.intro.set', $enrollment->hashId())}}"
               class="text-danger fw-bold float-end set-intro-session"
               title="View Intro Session Video">
                <i class="fa fa-play-circle fa-2x"></i>
            </a>
        @else

            <a href="https://www.dropbox.com/s/m38zr0ecbo8jtvn/Video%20de%20la%20misión%20del%20coach%202022.mp4"
               target="_blank"
               data-url-intro="{{route('get.student.session.intro.set', $enrollment->hashId())}}"
               class="text-primary fw-bold float-end set-intro-session"
               title="View Intro Session Video">
                <i class="fa fa-play-circle fa-2x"></i>
            </a>

        @endif
    </div>
</div>

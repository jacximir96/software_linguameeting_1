<div class="row">

    @if (isset($showIntroSession))
        <div class="col-12">
            @include('student.enrollment.intro_session', [
                'enrollment' => $enrollment,
            ])
        </div>
    @endif

    <div class="col-12 mt-3">

        @if ($itemBag instanceof \App\Src\StudentDomain\Enrollment\Service\ItemWeekBag)

            @foreach ($itemBag->sorted() as $coachingWeek)
                <div class="row mb-4">
                    @include('student.enrollment.sessions-bag.sessions_week', [
                        'coachingWeek' => $coachingWeek,
                        'itemBag' => $itemBag
                    ])
                </div>
            @endforeach

            @foreach ($itemBag->extraSessions() as $enrollmentSession)

                <div class="row mb-4">
                    @include('student.enrollment.session.booked', [
                       'enrollmentSession' => $enrollmentSession,
                       'session' => $enrollmentSession->session
                   ])
                </div>
            @endforeach

        @else

            @foreach ($itemBag->sorted() as $flexSession)

                <div class="row mb-4">

                    @include('student.enrollment.sessions-bag.sessions_flex', [
                        'flexSession' => $flexSession,
                        'itemBag' => $itemBag
                    ])
                </div>
            @endforeach

        @endif
    </div>
</div>

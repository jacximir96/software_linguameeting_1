    <div class="row mt-3">

        @foreach ($coachesActive as $coach)
            <div class="col-md-3 d-flex">
                @include('admin.course.schedule.mini_card_coach', ['coach' => $coach])
            </div>
        @endforeach
    </div>
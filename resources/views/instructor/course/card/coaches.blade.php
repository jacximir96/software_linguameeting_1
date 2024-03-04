<div class="container mt-5">
<div class="row">

    @forelse ($coaches as $coach)
        <div class="col-md-3 d-flex">
            @include('instructor.course.card.mini_card_coach', ['coach' => $coach])
        </div>
    @empty
        <div class="col-12 alert bg-gray-lighter fw-bold text-center ms-3">
            Students have not yet selected coaches
        </div>
    @endforelse
</div>
</div>



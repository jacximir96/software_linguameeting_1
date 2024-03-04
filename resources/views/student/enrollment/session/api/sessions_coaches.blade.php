@php $coaches = $viewData->schedule()->coaches() @endphp

@if ($coaches->count())

    <div class="row">
        <div class="col-xl-12">
            <div class="card-container element-with-scroll">
                @foreach ($coaches as $coach)

                    <div class="col-xl-3 card-coach-scroll">
                        <div class="row p-2">
                            <div class="col-12 border rounded">
                                @include('student.enrollment.session.makeup.info_coach', [
                                   'coach' => $coach,
                                   'reviewsStats' => $reviewsStatsCollection->getByCoach($coach)->reviewsStats(),
                                   'showFilterSessions' => true,
                                   'imageWidth' => 'w-50',
                               ])
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endif

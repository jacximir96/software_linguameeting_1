@extends('layouts.app')

@section('content')

    @include('user.row_status', ['user' => $coach])

    <div class="row my-3">
        <div class="col-xl-6">
            @include('admin.coach.card.personal_data',[
                'coach' => $data->coach()
            ])

            @include('user.activity.activity_card', [
                'activity' => $data->activity(),
                'user' => $data->coach()
               ])
        </div>

        <div class="col-xl-6">

            @if ($checkerRole->isCoachCoordinator($data->coach()->rol() ))
                @include('admin.coach.card.coordinator_of',[
                    'coach' => $data->coach(),
                    'coaches' => $data->coordinatedCoaches(),
                    'showAction' => true,
                ])
            @endif

            @if ($checkerRole->isCoach($data->coach()->rol() ))
                @include('admin.coach.card.coordinated_by',[
                    'coach' => $data->coach(),
                    'coaches' => $data->coordinatedBy(),
                    'showAction' => true,
                ])
            @endif

            @include('admin.coach.card.recordings',[
                'coach' => $data->coach(),
                'recordings' => $data->recordings(),
            ])

            @include('admin.coach.card.reviews',[
                'coach' => $data->coach(),
                'reviewsStats' => $data->reviewsStats(),
            ])

            @include('admin.coach.card.feedbacks',[
                'coach' => $data->coach(),
                'feedbacks' => $data->feedbacks(),
            ])
        </div>
    </div>


@endsection

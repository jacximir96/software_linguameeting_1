@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="w-5">ID</th>
                    <th>Name</th>
                    <th>Coordinator</th>
                    <th>First Semester<br>Finished</th>
                    <th>Second Semester<br>Finished</th>
                </tr>

                </thead>

                <tbody>

                @foreach ($coaches as $coach)

                    <tr>
                        <td>{{$coach->id}} </td>
                        <td>
                            <a href="{{route('get.admin.coach.show', $coach->hashId())}}"
                               title="Show Coach"
                               target="_blank">
                                {{$coach->writeFullName()}}
                            </a>
                        </td>
                        <td>
                            {{Form::select('coordinator_id', $coordinatorsOptions, $coach->coachCoordinated->coordinator_id ?? null,
                                [   'class'=>'form-control form-select change-coordinator',
                                    'placeholder' => 'Select Coordinator',
                                    'data-coach-id' => $coach->hashId(),
                                    'data-change-url' => route('post.admin.api.coach.coordinator.change', $coach->hashId())
                                    ])}}
                        </td>
                        <td>
                            {{Form::checkbox('semester_1', 1, $coach->semesterFinished->semester_1, [
                                                    'class' => 'form-check-input d-block change-semester-finished',
                                                    'data-semester-number' => 1,
                                                    'data-change-url' => route('post.admin.api.coach.semester.finished.change', $coach->hashId())
                                                    ])}}
                        </td>
                        <td>
                            {{Form::checkbox('semester_2', 2, $coach->semesterFinished->semester_2, [
                                                    'class' => 'form-check-input d-block change-semester-finished',
                                                    'data-semester-number' => 2,
                                                    'data-change-url' => route('post.admin.api.coach.semester.finished.change', $coach->hashId())
                                                    ])}}
                        </td>
                    </tr>

                @endforeach
                </tbody>

            </table>
        </div>
    </div>

@endsection

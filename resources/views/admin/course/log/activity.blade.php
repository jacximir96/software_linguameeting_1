@extends('layouts.app_modal')

@section('content')

    <div class="row">

        <div class="col-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Who?</th>
                        <th>ID</th>
                        <th>Model</th>
                        <th>Event</th>
                        <th>Extra</th>
                        <th>When?</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data->activityCollect()->sort() as $activityItem)
                    @php $activity = $activityItem->buildActivity(); @endphp
                    <tr>
                        <td>{{$activity->activity()->causer->writeFullName()}}</td>
                        <td>{{ $activity->activity()->subject->id }}</td>
                        <td>{{ $activity->nameModel() }}</td>
                        <td>{{ $activity->trans() }}</td>
                        <td>
                            @foreach ($activity->formattedProperties() as $formatter)
                                <span class="d-block">{{$formatter->print()}}</span>
                            @endforeach
                        </td>
                        <td>{{ toDatetimeInOneRow($activity->activity()->created_at, $timezone->name) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection

@extends('layouts.app_modal')

@section('content')


    <div class="row d-none d-sm-block">
        <div class="col-12">
            <table id="" class="table table-hover" data-paging="false" data-searching="false" data-ordering="false">
                <thead>
                <tr>
                    <th>Who?</th>
                    <th>Event</th>
                    <th>Extra</th>
                    <th>When?</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($activity as $activityItem)

                    @php $activityBuild = $activityItem->buildActivity(); @endphp

                    <tr>
                        <td>{{$activityBuild->activity()->causer->writeFullName()}}</td>
                        <td>{{ $activityBuild->trans() }}</td>
                        <td>
                            @foreach ($activityBuild->formattedProperties() as $formatter)
                                @if ($formatter instanceof \App\Src\ActivityLog\Service\Formatter\CarbonFormatter)
                                    <span class="d-block">{{$formatter->title()}}: {{toDatetimeInOneRow($formatter->value(), $timezone->name)}}</span>
                                @else
                                    <span class="d-block">{{$formatter->print()}}</span>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ toDatetimeInOneRow($activityBuild->activity()->created_at, $timezone->name) }}</td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="6">
                            <span class=" text-white bg-warning px-2 py-1 rounded ">No activity registered</span>
                        </td>
                    </tr>

                @endforelse
                </tbody>
            </table>

            {{$activity->render()}}
        </div>
    </div>

@endsection

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-corporate-color-light text-corporate-dark-color fw-bold">
        <span class="">
            <i class="fas fa-clipboard-list me-1"></i>
            Activity
        </span>
    </div>
    <div class="card-body">
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
            </div>
        </div>

        <div class="row d-block d-sm-none">

            <div class="col-12">
                @if ($activity->count())
                    <ul>
                        @foreach ($activity as $item)
                            <li>
                                <span class="d-block">{{$item->description}}</span>

                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class=" text-white bg-warning px-2 py-1 rounded ">No activity registered</span>
                @endif
            </div>

        </div>

        @if ($activity->count())
            <a href="{{route('get.user.activity.index', $user->id)}}"
               class="small open-modal d-block mt-1 text-primary float-end"
               data-modal-size="modal-lg"
               data-modal-reload="no"
               data-reload-type="parent"
               data-modal-title="Show activity">
                Show all
            </a>
        @endif
    </div>
</div>

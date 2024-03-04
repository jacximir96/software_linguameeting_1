@if ($coach->incentive->count())
    <table class="table table-hover">
        <thead>
        <th>Type</th>
        <th>Frequency</th>
        <th>Date</th>
        <th>Value</th>
        <th>Comments</th>
        <th>Action</th>

        </thead>

        <tbody>

        @foreach ($coach->incentiveSortedDesc() as $incentive)
            <tr>
                <td>{{$incentive->type->name}}</td>
                <td>{{$incentive->frequency->name}}</td>
                <td>{{toDate($incentive->date)}}</td>
                <td>{{$linguaMoney->format($incentive->value)}}</td>
                <td>
                    @if ($incentive->hasComments())
                        <a href="#"
                           class="popover-link small"
                           data-toggle="popover"
                           data-trigger="hover"
                           title="Comments" data-content="{!! $incentive->comments !!}">show</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{route('get.admin.coach.billing.incentive.edit', $incentive->hashId())}}"
                       class="open-modal text-primary me-3"
                       data-modal-size="modal-md"
                       data-modal-reload="yes"
                       data-reload-type="parent"
                       data-modal-title='Edit Incentive'>
                        <i class="fa fa-edit"></i>
                    </a>

                    <a  href="{{route('get.admin.coach.billing.incentive.delete', $incentive->hashId())}}"
                        onclick="return confirm('Are you sure you want to delete this incentive?');"
                        title="Delete Incentive ">
                        <i class="fa fa-times text-danger"></i>
                    </a>

                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@else
    <span class="">Coach no tiene incentivos.</span>
@endif

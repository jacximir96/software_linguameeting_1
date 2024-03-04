@if ($coach->discount->count())
    <table class="table table-hover">
        <thead>
        <th>Type</th>
        <th>Date</th>
        <th>Value</th>
        <th>Comments</th>
        <th>Action</th>
        </thead>

        <tbody>

            @foreach ($coach->discountSortedDesc() as $discount)
                <tr>
                    <td>{{$discount->type->name}}</td>
                    <td>{{toDate($discount->date)}}</td>
                    <td>{{$linguaMoney->format($discount->value)}}</td>
                    <td>
                        @if ($discount->hasComments())
                            <a href="#"
                               class="popover-link small"
                               data-toggle="popover"
                               data-trigger="hover"
                               title="Comments" data-content="{!! $discount->comments !!}">show</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>

                        <a href="{{route('get.admin.coach.billing.discount.edit', $discount->hashId())}}"
                           class="open-modal text-primary me-3"
                           data-modal-size="modal-md"
                           data-modal-reload="yes"
                           data-reload-type="parent"
                           data-modal-title='Edit Discount'>
                            <i class="fa fa-edit"></i>
                        </a>

                        <a  href="{{route('get.admin.coach.billing.discount.delete', $discount->hashId())}}"
                            onclick="return confirm('Are you sure you want to delete this discount?');"
                            title="Delete Discount ">
                            <i class="fa fa-times text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@else
    <span class="">Coach no tiene descuentos.</span>
@endif

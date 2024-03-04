<table class="table table-hover">
    <thead>
    <tr>
        <th>Coach</th>
        <th>Year</th>
        <th>Month</th>
        <th>Total</th>
        <th>¿Paid?</th>
        <th>Invoice</th>
    </tr>

    </thead>

    <tbody>

    @foreach ($viewData->billingSorted() as $monthBillingResponse)
        @php $coach = $monthBillingResponse->getMonthBilling()->coach(); @endphp

        <tr>
            <td>
                <a href="{{route('get.admin.coach.show', $coach->hashId())}}"
                   title="Show Coach"
                   target="_blank">
                    {{$coach->id}} - {{$coach->writeFullName()}}

                    @if ($monthBillingResponse->isPayer())
                        <i class="ms-2 fa fa-hand-holding-usd" title="Payer Coach"></i>
                    @endif
                </a>

            </td>
            <td>{{$monthBillingResponse->getMonthBilling()->month()->year()}}</td>
            <td>{{writeMonth($monthBillingResponse->getMonthBilling()->month())}}</td>

            <td>
                @if ($monthBillingResponse->isPayer())

                    <a href="{{route('get.coach.billing.for_one.show_filtered', [$coach->hashId(), $month->month(), $month->year()])}}"
                       class="open-modal"
                       data-modal-reload="no"
                       data-modal-size="modal-lg"
                       data-modal-title='Salary Coach'
                       title="Salary Coach">
                        {{$linguaMoney->format($monthBillingResponse->totalSalary())}}
                    </a>

                    @php $total = $total->add($monthBillingResponse->totalSalary()) @endphp

                @else
                    <a href="{{route('get.coach.billing.for_one.show_filtered', [$coach->hashId(), $month->month(), $month->year()])}}"
                       class="open-modal"
                       data-modal-reload="no"
                       data-modal-size="modal-lg"
                       data-modal-title='Salary Coach'
                       title="Salary Coach">
                        {{$linguaMoney->format($monthBillingResponse->getMonthBilling()->monthSalary()->total())}}
                    </a>

                    @php $total = $total->add($monthBillingResponse->getMonthBilling()->monthSalary()->total()) @endphp
                @endif
            </td>

            <td>
                @php $payment = $monthBillingResponse->payment(); @endphp

                {{Form::checkbox('is_paid', 1, $payment->isPaid(), [
                            'class' => 'form-check-input d-block change-paid-payment',
                            'data-change-url' => route('post.admin.api.coach.billing.payment.change_paid', $payment->id)
                            ])}}
            </td>
            <td>
                @if ($monthBillingResponse->hasInvoice())
                    <a href="{{route('get.admin.coach.billing.invoice.download', $monthBillingResponse->invoice()->id)}}"
                       class="btna btn-xsa btn-primarya"
                       title="Download Invoice">
                        <i class="fa fa-download me-4"></i>
                    </a>

                    <a href="{{route('get.admin.coach.billing.invoice.delete', $monthBillingResponse->invoice()->id)}}"
                       class="btna btn-xsa btn-primarya text-danger"
                       onclick="return confirm('Are you sure you want to delete this invoice?');"
                       title="Delete Invoice">
                        <i class="fa fa-times me"></i>
                    </a>
                @else

                    @if ($monthBillingResponse->getMonthBilling()->coach()->canGenerateInvoice())

                        <a href="{{route('get.admin.coach.billing.invoice.generate_download.from_url', [
                                                        $monthBillingResponse->getMonthBilling()->coach()->id,
                                                        $monthBillingResponse->getMonthBilling()->month()->month(),
                                                        $monthBillingResponse->getMonthBilling()->month()->year(),
                                                        ])}}"
                           class="btn btn-xs btn-success"
                           title="Download Invoice">
                            <i class="fa fa-download me-1"></i> Generate
                        </a>

                    @else
                        <a  href="#"
                            title="No se puede generar factura, falta información de pago."
                            onclick="alert('No se puede generar la factura porque al coach le falta la información de pago.')"
                            class="btn btn-xs btn-light">
                            Sin factura
                        </a>
                    @endif

                @endif
            </td>
        </tr>

    @endforeach

    <tr>
        <td colspan="4"></td>
        <td class="fw-bold">Total</td>
        <td class="fw-bold">{{$linguaMoney->format($total)}}</td>
    </tr>

    </tbody>

</table>

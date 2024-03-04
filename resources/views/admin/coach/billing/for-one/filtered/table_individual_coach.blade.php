<table class="table table-hover">
    <thead>
    <tr>
        <th>Reference</th>
        <th>Initial Date</th>
        <th>Final Date</th>
        <th>Total Hours</th>
        <th>Total</th>
        <th>Invoice</th>
    </tr>

    </thead>

    <tbody>

    @include('admin.coach.billing.for-one.filtered.hours_working', ['monthBilling' => $monthBilling])

    @if ($monthBilling->hasExtraSalary())
        @include('admin.coach.billing.for-one.filtered.extra_salary', ['monthBilling' => $monthBilling])
    @endif

    @include('admin.coach.billing.for-one.filtered.discounts', ['monthBilling' => $monthBilling])

    @include('admin.coach.billing.for-one.filtered.incentives', ['monthBilling' => $monthBilling])

    <tr class="fw-bold">
        <td class="">Total Salary</td>
        <td>{{toDate($monthBilling->month()->period()->getStartDate())}}</td>
        <td>{{toDate($monthBilling->month()->period()->getEndDate())}}</td>
        <td>
            @if ($monthBilling->monthSalary()->baseSalary()->getSalaryType()->isFixed())
                {{$monthBilling->monthSalary()->baseSalary()->getSalaryType()->name}}
            @else
                {{$monthBilling->monthSalary()->baseSalary()->getHours()}}
            @endif
        </td>
        <td>
            <span class="bg-corporate-color-light text-decoration-underline">{{$linguaMoney->format($monthBilling->monthSalary()->total())}}</span>
        </td>
        <td></td>
    </tr>
    </tbody>

</table>

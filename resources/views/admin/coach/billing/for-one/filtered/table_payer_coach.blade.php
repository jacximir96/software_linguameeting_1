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

    <tr>
        <td>
            Salary from all your coaches
            <a href="{{route('get.coach.billing.for_one.show_coordinated', [$coach->hashId(), $month->month(), $month->year()])}}"
               class="open-modal"
               data-modal-reload="no"
               data-modal-size=""
               data-modal-fullscreen="modal-fullscreen"
               data-modal-title='Salary Coordinated Coach'
               title="Salary Coordinated Coach">
                <i class="fa fa-eye"></i>
            </a>
        </td>
        <td>{{toDate($monthBilling->month()->period()->getStartDate())}}</td>
        <td>{{toDate($monthBilling->month()->period()->getEndDate())}}</td>
        <td>
            {{$viewData->totalHoursCoaches()}}
        </td>
        <td>
            {{$linguaMoney->format($viewData->totalSalaryCoaches())}}
        </td>
        <td></td>
    </tr>

    @include('admin.coach.billing.for-one.filtered.hours_working', ['monthBilling' => $monthBilling])

    @if ($monthBilling->hasExtraSalary())
        @include('admin.coach.billing.for-one.filtered.extra_salary', ['monthBilling' => $monthBilling])
    @endif

    @include('admin.coach.billing.for-one.filtered.discounts', ['monthBilling' => $monthBilling])

    @include('admin.coach.billing.for-one.filtered.incentives', ['monthBilling' => $monthBilling])

    <tr class="">
        <td class="">Your Salary </td>
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
            <span class="bg-corporate-color-light text-decoration-underline">{{$linguaMoney->format($viewData->totalSalary())}}</span>
        </td>
        <td></td>
    </tr>
    </tbody>

</table>

<tr>
    <td>Hours of working</td>
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
        {{$linguaMoney->format($monthBilling->monthSalary()->baseSalary()->getSalary())}}
    </td>
    <td></td>
</tr>

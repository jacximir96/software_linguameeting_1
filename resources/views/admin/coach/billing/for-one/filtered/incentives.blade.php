<tr>
    <td class="text-success">Incentives</td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        @if ($monthBilling->hasIncentives())
            <span class="text-success">{{$linguaMoney->format($monthBilling->monthSalary()->baseIncentive()->total())}}</span>
        @else
            -
        @endif
    </td>
    <td></td>
</tr>

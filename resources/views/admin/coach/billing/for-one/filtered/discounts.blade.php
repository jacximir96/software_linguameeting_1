<tr>
    <td class="text-corporate-danger">Discounts</td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        @if ($monthBilling->hasDiscounts())
            <span class="text-corporate-danger">- {{$linguaMoney->format($monthBilling->monthSalary()->baseDiscount()->getDiscount())}}</span>
        @else
            -
        @endif
    </td>
    <td></td>
</tr>

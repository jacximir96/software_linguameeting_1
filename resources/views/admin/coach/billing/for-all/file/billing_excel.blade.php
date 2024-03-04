<table>
    <thead>
    <tr>
        <th colspan="18"></th>
    </tr>
    <tr>
        <th colspan="18"></th>
    </tr>
    <tr class="header-cell">
        <th style="color:#39b4b3"><strong>NAME</strong></th>
        <th style="color:#39b4b3"><strong>FULL NAME(Bank Account)</strong></th>
        <th style="color:#39b4b3"><strong>PAYMENT OPTION</strong></th>
        <th style="color:#39b4b3"><strong>TOTAL AMOUNT</strong></th>
        <th style="color:#39b4b3"><strong>TOTAL HOUR</strong></th>
        <th style="color:#39b4b3"><strong>SALARY/HOUR</strong></th>
        <th style="color:#39b4b3"><strong>EMAIL</strong></th>
        <th style="color:#39b4b3"><strong>IDENTITY NATIONAL DOCUMENT</strong></th>
        <th style="color:#39b4b3"><strong>BANK NAME</strong></th>
        <th style="color:#39b4b3"><strong>BANK NUMBER</strong></th>
        <th style="color:#39b4b3"><strong>SWIFT/BIC</strong></th>
        <th style="color:#39b4b3"><strong>CURRENCY</strong></th>
        <th style="color:#39b4b3"><strong>COUNTRY</strong></th>
        <th style="color:#39b4b3"><strong>ADDRESS</strong></th>
        <th style="color:#39b4b3"><strong>POSTAL CODE</strong></th>
        <th style="color:#39b4b3"><strong>CITY</strong></th>
        <th style="color:#39b4b3"><strong>PAYPAL ACCOUNT</strong></th>
        <th style="color:#39b4b3"><strong>OBSERVATIONS</strong></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="6"></td>
    </tr>
    @forelse ($sortedBilling as $monthBillingResponse)
        @php
            $coach = $monthBillingResponse->getMonthBilling()->coach();
            $billingInfo = $coach->billingInfo;
            $backgroundColor = $monthBillingResponse->getMonthBilling()->backgroundColorInBillingFile();
        @endphp

        @if (is_null($billingInfo))
            @continue
        @endif

        <tr>
            <td style="background-color: {{$backgroundColor}}">
                {{$coach->name}} {{$coach->lastname}}
            </td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->full_name}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->methodPayment->name ?? ''}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$linguaMoney->format($monthBillingResponse->total())}}</td>
            <td style="background-color: {{$backgroundColor}}">
                @if ( ! $monthBillingResponse->isPayer())
                    {{$monthBillingResponse->hours()}}
                @endif
            </td>
            <td style="background-color: {{$backgroundColor}}">
                @if ($monthBillingResponse->hasSalary())
                    @if ($monthBillingResponse->salary()->type->isFixed())
                        Fijo
                    @else
                        {{$linguaMoney->format($monthBillingResponse->salary()->value)}}
                    @endif
                @else
                    Not has Salary
                @endif
            </td>
            <td style="background-color: {{$backgroundColor}}">{{$coach->email}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->ind}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->bank_name}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->bank_account}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->swift}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->currency->name}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$monthBillingResponse->country()->name}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->address}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->postal_code}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->city}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->paypal_email ?? ''}}</td>
            <td style="background-color: {{$backgroundColor}}">{{$billingInfo->bank_observations}}</td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="6">
                Coaches not found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

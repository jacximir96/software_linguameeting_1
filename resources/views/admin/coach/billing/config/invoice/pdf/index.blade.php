@extends('layouts.app_pdf')

@section('content')

    <style>
        .invoice-info-to p{
            margin:0
        }

    </style>

    <div class="content">

        <table border="0" align="left" class="w-100 mt-0" cellpadding="1" cellspacing="0">
            <tbody>
            <td class="">
                <hr class="h-10 background-color-corporate-dark m-0" >
            </td>
            </tbody>
        </table>

        <table border="0" align="left" class="w-100 mt-20" cellpadding="1" cellspacing="0">
            <tr>
                <td class="fs-25 text-end" style="color:#bbbaba">
                    BILLING
                </td>
            </tr>
        </table>

        <table border="0" align="left" class="w-100 mt-20" cellpadding="1" cellspacing="0">
            <tbody>
            <td class="w-15">
                <hr class="h-2 background-color-corporate-dark m-0" >
            </td>
            <td class="w-5"></td>
            <td class="w-35">
                <hr class="h-2 background-color-corporate-dark m-0" >
            </td>
            <td class="w-5"></td>
            <td class="w-35">
                <hr class="h-2 background-color-corporate-dark m-0" >
            </td>
            </tbody>
        </table>

        <table border="0" align="left" class="w-100 mt-0" cellpadding="1" cellspacing="0">
            <tbody>
            <tr>
                <td class="w-15 va-top">
                    <p class="fs-10 mb-0 mt-0">
                        NUMBER
                    </p>
                    <p class="mt-0">
                        <span class="bold">{{$invoice->number()}}</span>
                    </p>
                    <p style="border-bottom: 1px solid #ccc; margin:5px 0"></p>
                    <p class="fs-10 mb-0">
                        DATE
                    </p>
                    <p class="mt-0">
                        <span class="bold">{{toDate($invoice->date)}}</span>
                    </p>
                </td>
                <td class="w-5"></td>
                <td class="w-35 va-top">
                    <p class="fs-10 m-0">FROM</p>
                    {!! nl2br($invoice->info_from) !!}
                </td>
                <td class="w-5"></td>
                <td class="w-35 va-top">
                    <p class="fs-10 m-0">TO</p>
                    <div class="invoice-info-to">
                        {!! $invoice->info_to !!}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <table border="0" align="left" class="w-100 mt-20" cellpadding="1" cellspacing="0">
            <tbody>
            <tr>

                <td class="w-20">

                </td>

                <td class="w-80 va-top">
                    <table border="0" align="left" class="w-100" cellpadding="1" cellspacing="0">
                        <thead>
                        <tr>
                            <td colspan="4">
                                <hr class="h-2 m-0 background-color-corporate-dark" >
                            </td>
                        </tr>
                        <tr style="border-bottom: 2px solid #186e74">
                            <th class="bold w-55 text-start">Description</th>
                            <th class="bold w-15">Quantity</th>
                            <th class="bold w-15 text-end">Unit Price</th>
                            <th class="bold w-15 text-end">Amount</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($invoice->detail as $detail)
                            <tr>
                                <td class="border-bottom-corporate">{{$detail->description}}</td>
                                <td class="text-center border-bottom-corporate">{{$detail->quantity}}</td>
                                <td class="text-end border-bottom-corporate">{{$linguaMoney->format($detail->unit_price)}}</td>
                                <th class="text-end border-bottom-corporate">{{$linguaMoney->format($detail->price())}}</th>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                    <table border="0" align="left" class="w-100 mt-20" cellpadding="1" cellspacing="0">
                        <tbody>
                        <tr >
                            <td class="w-50"></td>
                            <td class="w-25 text-start border-bottom-corporate">
                                SUBTOTAL
                            </td>
                            <td class="w-25 text-end  border-bottom-corporate">
                                {{$linguaMoney->format($invoice->total())}}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50"></td>
                            <td class="w-25 text-start  border-bottom-corporate">
                                VAT (00,00%)*
                            </td>
                            <td class="w-25 text-end  border-bottom-corporate">
                                {{$linguaMoney->format($linguaMoney->buildZero($invoice->currency))}}
                            </td>
                        </tr>
                        <tr style="font-size:13px">
                            <td class="w-50 bold"></td>
                            <td class="w-25 bold text-start  border-bottom-corporate">
                                TOTAL
                            </td>
                            <td class="w-25 bold text-end border-bottom-corporate">
                                <span class="bold">{{$invoice->currency}}</span> {{$linguaMoney->format($invoice->total())}}
                            </td>
                        </tr>
                        </tbody>

                    </table>


                    <table border="0" align="left" class="w-100 mt-50" cellpadding="1" cellspacing="0">
                        <tbody>
                        <tr>
                            <td colspan="4">
                                <span class="text-muteda">
                                   * Commission for intermediation in sales. Operation is not subject to VAT due to location rules. Article 70.2
                                    of the General VAT Law.
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

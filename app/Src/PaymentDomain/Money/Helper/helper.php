<?php

if (! function_exists('format_money')) {

    function format_money(Money\Money $money)
    {
        $linguaMoney = new \App\Src\PaymentDomain\Money\Service\LinguaMoney();

        return $linguaMoney->format($money);
    }
}

<?php

namespace App\Src\PaymentDomain\Money\Service;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class LinguaMoney
{
    public function buildFromCents(int $cents, string $moneda = 'USD')
    {
        return new Money($cents, new Currency($moneda));
    }

    public function buildFromFloat(float $amount, string $currency = 'USD'): Money
    {
        $amount = round($amount, 2);

        $amount = $amount * 100;

        $amount = (int) $amount;

        return new Money($amount, new Currency($currency));
    }

    public function buildZero(string $currency = 'USD'): Money
    {
        return new Money(0, new Currency($currency));
    }

    public function format(Money $money)
    {
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }

    public function formatToFloat(Money $money)
    {
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter('en_EN', NumberFormatter::PATTERN_DECIMAL);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }

    public function formatForFormField(Money $amount): string
    {
        return $this->formatToFloat($amount);

        return str_replace(',', '.', $amount->getAmount() / 100);
    }
}

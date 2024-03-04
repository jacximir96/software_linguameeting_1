<?php

namespace App\Src\PaymentDomain\Money\Service;

use Money\Money;

trait TraitModelMoney
{
    public function fieldWithMoney(string $amountField): bool
    {
        $amountField = 'amount_'.$amountField;

        return ! is_null($this->attributes[$amountField]);
    }

    public function getMoneyAttribute(string $amountField): Money
    {
        $amountField = 'amount_'.$amountField;
        $currencyField = 'currency_'.$amountField;

        if (is_null($this->attributes[$amountField])) {
            return $this->buildZero();
        }

        return $this->centsToMoney($this->attributes[$amountField], $this->attributes[$currencyField]);
    }

    public function setMoneyAttribute(Money $money, string $amountField)
    {
        $amountField = 'amount_'.$amountField;
        $currencyField = 'currency_'.$amountField;

        $this->attributes[$amountField] = $money->getAmount();
        $this->attributes[$currencyField] = $money->getCurrency()->getCode();
    }

    public function amountFieldToNull(string $amountField)
    {
        $amountField = 'amount_'.$amountField;
        $currencyField = 'currency_'.$amountField;

        $this->attributes[$amountField] = null;
        $this->attributes[$currencyField] = null;
    }
}

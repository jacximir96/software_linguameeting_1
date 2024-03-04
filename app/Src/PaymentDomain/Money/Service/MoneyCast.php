<?php

namespace App\Src\PaymentDomain\Money\Service;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        $money = new LinguaMoney();

        $moneyField = 'amount_'.$key;
        $currencyField = 'currency_'.$key;

        if (is_null($model->$moneyField)) {
            return $money->buildZero();
        }

        return $money->buildFromCents($model[$moneyField], $model[$currencyField]);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        $amountField = 'amount_'.$key;
        $currencyField = 'currency_'.$key;

        if (is_null($value)) {
            return [
                $amountField => null,
                $currencyField => null,
            ];
        }

        return [
            $amountField => (int) $value->getAmount(),
            $currencyField => $value->getCurrency()->getCode(),
        ];
    }
}

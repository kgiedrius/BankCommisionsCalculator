<?php

namespace App\Paysera;

class Currency
{
    public static function convertFromEur($amount, $currency = 'EUR')
    {
        $rates = config('bank.currencyRates');

        return $amount * $rates[ $currency ];
    }

    public static function convertToEur($amount, $currency = 'EUR')
    {
        $rates = config('bank.currencyRates');

        return $amount / $rates[ $currency ];
    }

    public static function round($amount, $currency = 'EUR')
    {
        $decimals = config('bank.currencyRoundDecimals')[ $currency ];
        if ($decimals > 0) {
            return number_format(ceil($amount * pow(10, $decimals)) / pow(10, $decimals), $decimals);
        } else {
            return number_format(ceil($amount), 0);
        }
    }
}

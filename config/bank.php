<?php

return [
    'paymentPlans'  => [
        'legal'   => \App\Paysera\PaymentPlans\Legal::class,
        'natural' => \App\Paysera\PaymentPlans\Natural::class,
    ],
    'currencyRates' => [
        'EUR' => 1,
        'USD' => 1.1497,
        'JPY' => 129.53
    ],
    'currencyRoundDecimals' => [
        'EUR' => 2,
        'USD' => 2,
        'JPY' => 0,
    ]

];

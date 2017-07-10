<?php
/**
 * Created by PhpStorm.
 * User: giedrius
 * Date: 7/5/17
 * Time: 10:24
 */

namespace App\Paysera\PaymentPlans;

use App\Paysera\Currency;

class Plans
{
    protected function calculateCacheInCommision($data)
    {
        $amount = 0.03 / 100 * $data['amount'];
        if (Currency::convertToEur($amount, $data['currency']) > 5) {
            return Currency::convertFromEur(5, $data['currency']);
        }

        return $amount;
    }
}

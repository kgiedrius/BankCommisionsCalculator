<?php

namespace App\Paysera\PaymentPlans;

use App\Transaction;

interface PaymentPlanInterface
{
    public function commissions(Transaction $transaction);
}

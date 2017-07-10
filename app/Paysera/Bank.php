<?php
/**
 * Created by PhpStorm.
 * User: giedrius
 * Date: 7/4/17
 * Time: 17:53
 */

namespace App\Paysera;

use App\Transaction;

class Bank
{
    private $paymentPlans = [ ];


    public function __construct()
    {
        $this->initPlans();
    }

    public function calculateCommission(Transaction $transaction)
    {
        $plan = strtolower(trim($transaction->get()['client_plan']));
        return $this->paymentPlans[$plan]->commissions($transaction);
    }

    private function initPlans()
    {
        $plans = config('bank.paymentPlans');
        array_walk($plans, function ($plan, $key) {
            $this->paymentPlans[ $key ] = app()->make($plan);
        });
    }
}

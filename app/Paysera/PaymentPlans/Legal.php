<?php

namespace App\Paysera\PaymentPlans;

use App\Paysera\Currency;
use App\Transaction;
use League\Flysystem\Exception;

class Legal extends Plans implements PaymentPlanInterface
{
    public function commissions(Transaction $transaction)
    {
        $transaction = $transaction->get();

        switch ($transaction['transaction_type']) {
            case 'cash_in':
                $amount = $this->calculateCacheInCommision($transaction);
                break;
            case 'cash_out':
                $amount = $this->calculateCacheOutCommision($transaction);
                break;
            default:
                throw new Exception('not supported operation: ' . $transaction['transaction_type']);
        }

        return Currency::round($amount, $transaction['currency']);
    }

    protected function calculateCacheOutCommision($data)
    {
        $commission = 0.3 / 100 * $data['amount'];
        $commisionInEur = Currency::convertToEur($commission, $data['currency']);
        if ($commisionInEur < 0.5) {
            $commission = Currency::convertFromEur(0.5, $data['currency']);
        }

        return $commission;
    }
}

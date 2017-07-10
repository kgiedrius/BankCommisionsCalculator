<?php

namespace App\Paysera\PaymentPlans;

use App\Paysera\Currency;
use App\Transaction;

class Natural extends Plans implements PaymentPlanInterface
{
    private $clientCashoutTransactionsHistory = [ ];

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
                $amount = 'not supported operation';
        }

        return Currency::round($amount, $transaction['currency']);
    }

    protected function calculateCacheOutCommision($data)
    {
        $commission = 0.3 / 100 * $data['amount'];

        $transactionWeekKey = $data['client_id'] . date('YW', strtotime($data['date']));
        $weekTransactions = isset($this->clientCashoutTransactionsHistory[ $transactionWeekKey ]) ? $this->clientCashoutTransactionsHistory[ $transactionWeekKey ] : [ ];
        $amountInEur = Currency::convertToEur($data['amount'], $data['currency']);

        if (array_sum($weekTransactions) < 1000) {
            $commisionsInEur = (array_sum($weekTransactions) + $amountInEur - 1000) * 0.3 / 100;
            $commission = Currency::convertFromEur($commisionsInEur, $data['currency']);
        }

        if (count($weekTransactions) >= 3) {
            $commission = 0.3 / 100 * $data['amount'];
        }

        $this->clientCashoutTransactionsHistory[ $transactionWeekKey ][] = $amountInEur;

        return $commission > 0 ? $commission : 0;
    }
}

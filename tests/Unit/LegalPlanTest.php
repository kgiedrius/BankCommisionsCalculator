<?php

namespace Tests\Unit;

use App\Paysera\Bank;
use App\Paysera\Currency;
use App\Transaction;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LegalPlanTest extends TestCase
{
    /**
     * @test
     */
    public function cashin_cost_003_percent()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'legal', 'cash_in', 100, 'EUR' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(0.03, $commision);
    }

    /**
     * @test
     */
    public function cashin_cost_do_not_exceed_5_eur()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'legal', 'cash_in', 20000, 'EUR' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(5.00, $commision);
    }

    /**
     * @test
     */
    public function cashout_cost_03_percent()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'legal', 'cash_out', 1000, 'EUR' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(3.00, $commision);
    }

    /**
     * @test
     */
    public function cashout_minimum_cost_05_eur()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'legal', 'cash_out', 1, 'EUR' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(0.5, $commision);
    }

    /**
     * @test
     */
    public function cashout_minimum_cost_05_eur_when_currency_jpy()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'legal', 'cash_out', 1000, 'JPY' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(Currency::round(config('bank.currencyRates.JPY') * 0.5, 'JPY'), $commision);
    }
}

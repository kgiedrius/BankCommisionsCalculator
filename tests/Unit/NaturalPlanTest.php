<?php

namespace Tests\Unit;

use App\Paysera\Bank;
use App\Transaction;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NaturalPlanTest extends TestCase
{
    /**
     * @test
     */
    public function cashin_cost_003_percent()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'natural', 'cash_in', 100, 'EUR' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(0.03, $commision);
    }

    /**
     * @test
     */
    public function cashin_cost_do_not_exceed_5_eur()
    {
        $transaction = new Transaction([ '2016-01-05', 1, 'natural', 'cash_in', 20000, 'EUR' ]);
        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction);
        $this->assertEquals(5.00, $commision);
    }

    /**
     * @test
     */
    public function cashout_cost_0_upto_1000_eur_same_week()
    {
        $transaction1 = new Transaction([ '2016-01-05', 1, 'natural', 'cash_out', 400, 'EUR' ]);
        $transaction2 = new Transaction([ '2016-01-06', 1, 'natural', 'cash_out', 600, 'EUR' ]);

        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction1);
        $commision += $bank->calculateCommission($transaction2);

        $this->assertEquals(0, $commision);
    }

    /**
     * @test
     */
    public function cashout_cost_0_upto_1000_eur_per_week()
    {
        $transaction1 = new Transaction([ '2017-01-01', 1, 'natural', 'cash_out', 1000, 'EUR' ]);
        $transaction2 = new Transaction([ '2017-01-08', 1, 'natural', 'cash_out', 1000, 'EUR' ]);
        $transaction3 = new Transaction([ '2017-01-17', 1, 'natural', 'cash_out', 1000, 'EUR' ]);

        $bank = app()->make(Bank::class);
        $commision = $bank->calculateCommission($transaction1);
        $commision += $bank->calculateCommission($transaction2);
        $commision += $bank->calculateCommission($transaction3);

        $this->assertEquals(0, $commision);
    }

    /**
     * @test
     */
    public function cashout_cost_calculated_from_exceeded_amount()
    {
        $transaction1 = new Transaction([ '2016-01-01', 1, 'natural', 'cash_out', 250, 'EUR' ]);
        $transaction2 = new Transaction([ '2016-01-02', 1, 'natural', 'cash_out', 750, 'EUR' ]);
        $transaction3 = new Transaction([ '2016-01-03', 1, 'natural', 'cash_out', 200, 'EUR' ]);

        $bank = app()->make(Bank::class);

        $commision = $bank->calculateCommission($transaction1);
        $commision += $bank->calculateCommission($transaction2);
        $commision += $bank->calculateCommission($transaction3);

        $this->assertEquals(0.6, $commision);
    }

    /**
     * @test
     */
    public function cashout_4th_transaction_cost_03_percent()
    {
        $transaction1 = new Transaction([ '2016-01-01', 1, 'natural', 'cash_out', 100, 'EUR' ]);
        $transaction2 = new Transaction([ '2016-01-01', 1, 'natural', 'cash_out', 100, 'EUR' ]);
        $transaction3 = new Transaction([ '2016-01-01', 1, 'natural', 'cash_out', 100, 'EUR' ]);
        $transaction4 = new Transaction([ '2016-01-01', 1, 'natural', 'cash_out', 100, 'EUR' ]);

        $bank = app()->make(Bank::class);

        $commision = $bank->calculateCommission($transaction1);
        $commision += $bank->calculateCommission($transaction2);
        $commision += $bank->calculateCommission($transaction3);
        $commision += $bank->calculateCommission($transaction4);

        $this->assertEquals(0.3, $commision);
    }
}

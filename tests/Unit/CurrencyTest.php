<?php

namespace Tests\Unit;

use App\Paysera\Currency;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * @test
     */
    public function test_eur_rounding()
    {
        $this->assertEquals(10.12, Currency::round(10.1111, 'EUR'));
    }

    /**
     * @test
     */
    public function test_jpy_rounding()
    {
        $this->assertEquals(11, Currency::round(10.11211, 'JPY'));
    }
}

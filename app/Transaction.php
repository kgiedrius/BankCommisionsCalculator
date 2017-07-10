<?php

namespace App;

class Transaction
{
    private $data = [
        'date',
        'client_id',
        'client_plan',
        'transaction_type',
        'amount',
        'currency'
    ];

    public function __construct($data)
    {
        return $this->data = array_combine($this->data, $data);
    }

    public function get()
    {
        return $this->data;
    }
}

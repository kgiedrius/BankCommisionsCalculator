<?php

namespace App\Console\Commands;

use App\Paysera\Bank;
use App\Transaction;
use Illuminate\Console\Command;
use League\Csv\Reader;

class Commisions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paysera:commisions {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate commisions from csv file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csvFile = base_path().DIRECTORY_SEPARATOR.$this->argument('file');
        $reader = Reader::createFromPath($csvFile);
        $results = $reader->fetch();
        $bank = new Bank();

        foreach ($results as $row) {
            $this->line($bank->calculateCommission((new Transaction($row))));
        }
    }
}

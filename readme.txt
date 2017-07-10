Prepare system:
1. composer install

Run tests:
2. phpunit  or  ./vendor/bin/phpunit

Process Transactions (CSV file must present in project root directory.)
3. php artisan paysera:commisions input.csv


About project:
Created 2 commision plans (legal & natural), more plans can be added to configuration file & implemented as separate classes.

Source code is in:
    app\Console\Commands\Commisions.php
    app\Paysera\*
    app\Transaction.php
Configuration:
    config\bank.php
Tests are in:
    tests\Unit\*


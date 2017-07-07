 Requirements

There are no tight restrictions on time, but there is no loss of communication - if you encounter problems or do not get free time, contact
The task must be done in PHP, the version chosen freely
External dependencies, tools, frameworks can be used if this is considered necessary. We recommend using composer even if you do not use external libraries for autoloading - we recommend using the PSR-4 standard.
The system should be supported:
Clear dependencies between parts of the code
The system is tested and tested
Code understandable simple
The system must be expanded:
To add a new functionality or to change the existing one, you do not need to rewrite the entire system
The code should correspond to PSR-1 and PSR-2
The minimum documentation should be provided:
How to run the system (what kind of command to execute)
How to run system tests (what kind of command to execute)
A brief description of functionality in less clear areas may be in the code itself
 Task

 The situation

Paysera users can come to the department to contribute and cash out. Several currencies are supported. There are also certain commissions for both cash and cash.

 Commission Fees

 Money deposit

Commission fee - 0.03% of the amount, not more than 5.00 EUR.

 Cash clearing

Different commissions apply to natural and legal persons.

 For individuals

Ordinary commission - 0.3% of the amount.

EUR 1000.00 per week (Monday to Sunday) can be taken out for free.

If the amount is exceeded - the commission is calculated only from the overrun (ie EUR 1000 is still valid without commission).

This discount only applies to the first 3 withdrawal operations per week - if the 4th and subsequent times are deducted, the commission for these operations is normally calculated - the rule for 1000 EUR is valid only for the first three discharges.

 For legal entities

Commission fee - 0.3% of the amount, but not less than 0.50 EUR.

 Commission fee currency

The commission fee is always calculated in the currency in which the transaction is performed (for example, in USD , the commission is also in USD currency).

 Rounding

After calculating the commission, it is rounded to the nearest point with the accuracy of the smallest currency unit (eg EUR cents - cents) ( 0.023 EUR round 3 Euro cents).

Rounding is done after the conversion.

 Supported currencies

Supported 3 currencies: EUR , USD and JPY .

When converting currencies, the following conversion rates apply: EUR:USD - 1:1.1497 , EUR:JPY - 1:129.53

 Input data

Input data is provided in a CSV file. The file contains the executed operations. Each line contains the following data:

Operation date, format Ymd
User identifier, number
User type, one of natural (natural person) or legal (legal entity)
Type of transaction, one from cash_in ( cash_in ) or cash_out (clearing)
Transaction amount (e.g. 2.12 or 3 )
Transaction currency, one of EUR , USD , JPY
All operations are ordered in their order, but may include a range of several years.

 Expected result

The program has the only argument to accept the path to the data file.

The program must submit the result to stdout .

The result is the calculation of commissions for each transaction. Each line must contain only the final amount of the commission fee without currency.

 Sample data

 ➜ cat input.csv 2016-01-05,1,natural,cash_in,200.00,EUR 2016-01-06,2,legal,cash_out,300.00,EUR 2016-01-06,1,natural,cash_out,30000,JPY 2016-01-07,1,natural,cash_out,1000.00,EUR 2016-01-07,1,natural,cash_out,100.00,USD 2016-01-10,1,natural,cash_out,100.00,EUR 2016-01-10,2,legal,cash_in,1000000.00,EUR 2016-01-10,3,natural,cash_out,1000.00,EUR 2016-02-15,1,natural,cash_out,300.00,EUR ➜ php script.php input.csv 0.06 0.90 0 0.70 0.30 0.30 5.00 0.00 0.00 
 Rating

Do all requirements apply correctly
Code quality - whether it is supported, expanded, tested; Less attention is paid, but the speed of the system can also be taken into account
 Task submission

If convenient, the code can be edited and / or publicly available (for example, GitHub), but we will ask you to submit the final source code in the zip archive by sending an e-mail. Mail code@paysera.lt .

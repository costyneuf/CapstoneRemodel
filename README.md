# CapstoneRemodel

## Instructions for environment setup and Laravel 5.6

* [Laravel 5.6](https://laravel.com/docs/5.6) - The documents for the web framework used
* [PHP](http://us1.php.net/manual/en/langref.php) - Manual for language reference

## Commands for test

Test the following features with corresponding commands in command window for your local repository.

### Write Resident_Education_Report.yearmonthday.csv into Database

e.g. Insert data from Resident_Education_Report.20180615.csv file into database table, and combine data sets 
for the next three days.

```
php artisan educationReport:add 20180615 --process=2018-06-16 --process=2018-06-17 --process=2018-06-18
```

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

## NOTES

Code in views/schedules/resident/schedule_basic.blade.php might be different based on the servers.

```
var url = current_url.search('/filter/') > -1 ? current_url.substr(0, current_url.search('/filter/')) : current_url;
url = url + "/filter/" + doctor_selected + "_" + start_after_selected + "_" + end_before_selected;
```

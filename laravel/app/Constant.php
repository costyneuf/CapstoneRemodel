<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    // Path used to open .csv files
    const WEB_PATH = __DIR__."/../../resources/Resident_Education_Report.";
    const CONSOLE_PATH = __DIR__."/../../resources/Resident_Education_Report.";
    const EXTENSION = ".csv";

    /**
     * .csv Columns Index
     */
    const DATE = 0;
    const LOCATION = 1;
    const ROOM = 2;
    const CASE_PROCEDURE = 3;
    const LEAD_SURGEON = 4;
    const PATIENT_CLASS = 5;
    const START_TIME = 6;
    const END_TIME = 7;

    /**
     * Output offset
     */
    const OFFSET_PROCEDURE = 9;

}

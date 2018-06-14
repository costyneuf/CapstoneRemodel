<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Models used in ScheduleDataController
 */
use App\ScheduleData;



class ScheduleDataController extends Controller
{

    /**
     * Private functions
     */

    /**
     * Filter data to output.
     */
    private static function updateData(array $args = array())
    {
        /**
         * Set up default input values.
         */
        $date = $args['date'];
        $doctor = !isset($args['lead_surgeon']) ? "TBD" : $args['lead_surgeon'];
        $start_time = !isset($args['start_time']) ? '00:00:00' : $args['start_time'];
        $end_time = !isset($args['end_time']) ? '23:59:59' : $args['end_time'];

        $schedule_data = null;
        if (strcmp($doctor, "TBD") == 0)
        {
            $schedule_data = ScheduleData::whereDate('date', $date)
                                ->whereTime('start_time', '>=', $start_time)
                                ->whereTime('end_time', '<=', $end_time)
                                ->orderBy('room', 'asc')
                                ->get();
        }
        else
        {
            $schedule_data = ScheduleData::whereDate('date', $date)
                                ->where('lead_surgeon', $doctor)
                                ->whereTime('start_time', '>=', $start_time)
                                ->whereTime('end_time', '<=', $end_time)
                                ->orderBy('room', 'asc')
                                ->get();
        }

        return $schedule_data;
    }


    /**
     * Public functions
     */
    public function getFirstDay($doctor=null, $start_time=null, $end_time=null)
    {
        $year = date("o", strtotime('+1 day'));
        $mon = date('m',strtotime('+1 day'));
        $day = date('j',strtotime('+1 day'));
        if (date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+3 day'));
            $mon = date('m',strtotime('+3 day'));
            $day = date('j',strtotime('+3 day'));
        }
        
        $date =  $year.'-'.$mon.'-'.$day;
        $schedule_data = self::updateData(array('date' => $date));

        return view('schedules.resident.schedule_table',compact('schedule_data', 'year', 'mon', 'day'));
 
    }

    public function getSecondDay()
    {
        $year = date("o", strtotime('+2 day'));
        $mon = date('m',strtotime('+2 day'));
        $day = date('j',strtotime('+2 day'));
        if (date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+4 day'));
            $mon = date('m',strtotime('+4 day'));
            $day = date('j',strtotime('+4 day'));
        }

        $date =  $year.'-'.$mon.'-'.$day;
        $schedule_data = self::updateData(array('date' => $date));

        return view('schedules.resident.schedule_table',compact('schedule_data', 'year', 'mon', 'day'));
    }

    public function getThirdDay()
    {
        $year = date("o", strtotime('+3 day'));
        $mon = date('m',strtotime('+3 day'));
        $day = date('j',strtotime('+3 day'));
        if (date("l", strtotime('today'))=='Wednesday' || date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+5 day'));
            $mon = date('m',strtotime('+5 day'));
            $day = date('j',strtotime('+5 day'));
        } 

        $date =  $year.'-'.$mon.'-'.$day;
        $schedule_data = self::updateData(array('date' => $date));

        return view('schedules.resident.schedule_table',compact('schedule_data', 'year', 'mon', 'day'));

    }

}

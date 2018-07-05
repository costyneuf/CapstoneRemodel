<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Models used in ScheduleDataController
 */
use App\ScheduleData;
use App\ScheduleParser;



class ScheduleDataController extends Controller
{

    /**
     * Protected members
     */
    protected $doctor = null;
    protected $start_time = null;
    protected $end_time = null;


    /**
     * Private functions.
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

        if (strcmp($doctor, "null") == 0) {
            $doctor = "TBD";
        }
        if (strcmp($start_time, "null") == 0) {
            $start_time = "00:00:00";
        }
        if (strcmp($end_time, "null") == 0) {
            $end_time = "23:59:59";
        }

        $schedule_data = null;
        if (strcmp($doctor, "TBD") == 0)
        {
            $schedule_data = ScheduleData::whereDate('date', $date)
                                ->where('room', '<>', '')
                                ->whereTime('start_time', '>=', $start_time)
                                ->whereTime('start_time', '<>', '00:00:00')
                                ->whereTime('end_time', '<=', $end_time)
                                ->orderBy('room', 'asc')
                                ->get();
        }
        else
        {           
            $schedule_data = ScheduleData::whereDate('date', $date)
                                ->where('lead_surgeon', $doctor)
                                ->where('room', '<>', '')
                                ->whereTime('start_time', '>=', $start_time)
                                ->whereTime('start_time', '<>', '00:00:00')
                                ->whereTime('end_time', '<=', $end_time)
                                ->orderBy('room', 'asc')
                                ->get();
        }

        return $schedule_data;
    }

    private function processInput($doctor_start_time_end_time)
    {
        if ($doctor_start_time_end_time == null) return;

        $tp = stripos($doctor_start_time_end_time, '_');
        
        /**
         * Get doctor
         */
        $this->doctor = substr($doctor_start_time_end_time, 0, $tp);
        str_replace("%20", " ", $this->doctor);

        /**
         * Get times
         */
        $time_string = substr($doctor_start_time_end_time, $tp + 1);
        $tp = stripos($time_string, '_');
        $this->start_time = substr($time_string, 0, $tp);
        $this->end_time = substr($time_string, $tp + 1);

        if (strcmp($this->doctor, "null") == 0) {
            $this->doctor = null;
        }
        if (strcmp($this->start_time, "null") == 0) {
            $this->start_time = null;
        }
        if (strcmp($this->end_time, "null") == 0) {
            $this->end_time = null;
        }

    }


    /**
     * Public functions
     */
    public function getFirstDay($doctor_start_time_end_time=null)
    {
        // // Test
        // $parser = new ScheduleParser("20180614");
        // $parser->processScheduleData();

        $year = date("o", strtotime('+1 day'));
        $mon = date('m',strtotime('+1 day'));
        $day = date('j',strtotime('+1 day'));
        if (date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+3 day'));
            $mon = date('m',strtotime('+3 day'));
            $day = date('j',strtotime('+3 day'));
        } else if (date("l", strtotime('today'))=='Saturday') {
            $year = date("o", strtotime('+2 day'));
            $mon = date('m',strtotime('+2 day'));
            $day = date('j',strtotime('+2 day'));
        }
        
        $date =  $year.'-'.$mon.'-'.$day;

        $this->processInput($doctor_start_time_end_time);
        $schedule_data = self::updateData(array('date' => $date, 'lead_surgeon' => $this->doctor,
                                                'start_time' => $this->start_time, 'end_time' => $this->end_time));

        return view('schedules.resident.schedule_table',compact('schedule_data', 'year', 'mon', 'day'));
 
    }

    public function getSecondDay($doctor_start_time_end_time=null)
    {
        $year = date("o", strtotime('+2 day'));
        $mon = date('m',strtotime('+2 day'));
        $day = date('j',strtotime('+2 day'));
        if (date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+4 day'));
            $mon = date('m',strtotime('+4 day'));
            $day = date('j',strtotime('+4 day'));
        } else if (date("l", strtotime('today'))=='Saturday') {
            $year = date("o", strtotime('+3 day'));
            $mon = date('m',strtotime('+3 day'));
            $day = date('j',strtotime('+3 day'));
        }

        $date =  $year.'-'.$mon.'-'.$day;

        $this->processInput($doctor_start_time_end_time);
        $schedule_data = self::updateData(array('date' => $date, 'lead_surgeon' => $this->doctor,
                                                'start_time' => $this->start_time, 'end_time' => $this->end_time));

        return view('schedules.resident.schedule_table',compact('schedule_data', 'year', 'mon', 'day'));
    }

    public function getThirdDay($doctor_start_time_end_time=null)
    {
        $year = date("o", strtotime('+3 day'));
        $mon = date('m',strtotime('+3 day'));
        $day = date('j',strtotime('+3 day'));
        if (date("l", strtotime('today'))=='Wednesday' || date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+5 day'));
            $mon = date('m',strtotime('+5 day'));
            $day = date('j',strtotime('+5 day'));
        } else if (date("l", strtotime('today'))=='Saturday') {
            $year = date("o", strtotime('+4 day'));
            $mon = date('m',strtotime('+4 day'));
            $day = date('j',strtotime('+4 day'));
        }

        $date =  $year.'-'.$mon.'-'.$day;

        $this->processInput($doctor_start_time_end_time);
        $schedule_data = self::updateData(array('date' => $date, 'lead_surgeon' => $this->doctor,
                                                'start_time' => $this->start_time, 'end_time' => $this->end_time));

        return view('schedules.resident.schedule_table',compact('schedule_data', 'year', 'mon', 'day'));

    }

}

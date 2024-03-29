<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Resident;
use App\Attending;
use App\Option;
use App\ScheduleData;
use App\Assignment;
use App\Status;
use App\ScheduleParser;
use App\AutoAssignment;
use App\Google;

class PagesController extends Controller
{

    private function calculateFirst()
    {
        if (date("l", strtotime('today'))=='Friday') {
            return date("Y-m-d", strtotime('+3 day'));
        } else if (date("l", strtotime('today'))=='Saturday') {
            return date("Y-m-d", strtotime('+2 day'));
        }
        return date("Y-m-d", strtotime('+1 day'));
    }

    private function calculateSecond()
    {
        if (date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            return date("Y-m-d", strtotime('+4 day'));
        } else if (date("l", strtotime('today'))=='Saturday') {
            return date("Y-m-d", strtotime('+3 day'));
        }
        return date("Y-m-d", strtotime('+2 day'));
    }

    private function calculateThird()
    {
        if (date("l", strtotime('today'))=='Wednesday' || date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            return date("Y-m-d", strtotime('+5 day'));
        } else if (date("l", strtotime('today'))=='Saturday') {
            return date("Y-m-d", strtotime('+4 day'));
        }
        return date("Y-m-d", strtotime('+3 day'));
    }

    private function processSingleChoice($id)
    {
        $date = ScheduleData::where('id', $id)->value('date');
        $location = ScheduleData::where('id', $id)->value('location');
        $room = ScheduleData::where('id', $id)->value('room');
        $patient = ScheduleData::where('id', $id)->value('patient_class');
        $start_t = ScheduleData::where('id', $id)->value('start_time');
        $end_t = ScheduleData::where('id', $id)->value('end_time');

        return $date.", ".$room.", ".$patient.", ".$start_t." - ".$end_t;
    }

    private function processChoices($date, $id)
    {
        $day_arr = array(
            "first"=>null,
            "second"=>null,
            "thrid"=>null
        );

        $schedule1 = Option::where('date', $date)->where('resident', $id)->where('option', 1)->value('schedule');
        $schedule2 = Option::where('date', $date)->where('resident', $id)->where('option', 2)->value('schedule');
        $schedule3 = Option::where('date', $date)->where('resident', $id)->where('option', 3)->value('schedule');
        
        if ($schedule1 != null) {
            $day_arr['first'] = "First Choice: ".self::processSingleChoice($schedule1);
        }
        if ($schedule2 != null) {
            $day_arr['second'] = "Second Choice: ".self::processSingleChoice($schedule2);
        }
        if ($schedule3 != null) {
            $day_arr['third'] = "Third Choice: ".self::processSingleChoice($schedule3);
        }

        return $day_arr;
    }

    public function getIndex()
    {
        $date = date("Y-m-d", strtotime('today'));
        if (Status::where('date', $date)->doesntExist())
        {
            Status::insert([
                'date'=>$date
            ]);
        }
        if ((int)Status::where('date', $date)->value('schedule') < 1)
        {
            $parser = new ScheduleParser(date("o", strtotime('today')).date("m", strtotime('today')).date("j", strtotime('today')), true);
            $process_date = array(
                date("Y-m-d", strtotime('+2 day')),
                date("Y-m-d", strtotime('+3 day')),
                date("Y-m-d", strtotime('+4 day')),
                date("Y-m-d", strtotime('+5 day')),
            );
            foreach($process_date as $date)
            {
                $parser->processScheduleData($date);
            }
            $date = date("Y-m-d", strtotime('today'));
            if ($parser->fileExists()) {
                Status::where('date', $date)->update([
                    'schedule'=>true
                ]);
            }

        }

        $tomorrow = date("Y-m-d", strtotime('+1 day'));
        if (Status::where('date', $tomorrow)->doesntExist())
        {
            Status::insert([
                'date'=>$tomorrow
            ]);
        }
        if ((int)Status::where('date', $tomorrow)->value('assignment') != 1)
        {
            AutoAssignment::assignment($tomorrow);
            Status::where('date', $tomorrow)->update([
                'assignment'=>1
            ]);
        }
        if ((int)Status::where('date', $date)->value('google') < 1)
        {
            Google::updateSheets($date);
            Status::where('date', $date)->update([
                'google'=>1
            ]);
        }
        return view('schedules.index');
    }

    public function getAbout() {

        date_default_timezone_set('America/New_York');

        // Update user information here
        $name = $_SERVER["HTTP_DISPLAYNAME"];
        $email = $_SERVER["HTTP_EMAIL"];
        $roles = array();
        if (Admin::where('email', $email)->where('exists', '1')->exists())
        {
            array_push($roles, "Admin");
        } 
        if (Resident::where('email', $email)->where('exists', '1')->exists())
        {
            array_push($roles, "Resident");
        }

        // Update user schedule here
        $id = Resident::where('email', $_SERVER["HTTP_EMAIL"])->value('id');
        $date = self::calculateFirst();
        $firstday = null;
        if (Assignment::where('date', $date)->where('resident', $id)->exists()) {
            $firstday_id = Assignment::where('date', $date)->where('resident', $id)->value('schedule');
            $firstday = self::processSingleChoice($firstday_id);
        }

        $date = self::calculateSecond();
        $secondday = self::processChoices($date, $id);

        $date = self::calculateThird();
        $thirdday = self::processChoices($date, $id);

        // Parse data into array
        $data = array(
                    "name"=>$name,
                    "email"=>$email,
                    "roles"=>$roles,
                    "firstday"=>$firstday,
                    "secondday"=>$secondday,
                    "thirdday"=>$thirdday
        );

        return view('pages.about', compact('data'));
    }
    
    public function getContact() {
        return view('pages.contact');
    }

    public function getFeedback($date) {

        $year = substr($date, 0, 4);
        $mon = substr($date, 4, 2);
        $day = substr($date, 6, 2);
        $data_date = $year."-".$mon."-".$day;

        return view('pages.feedback', compact('data_date'));
    }
}

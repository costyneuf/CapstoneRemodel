<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Resident;
use App\Attending;
use App\Option;
use App\ScheduleData;

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

        return $date.", ".$location.", ".$room.", ".$patient.", ".$start_t.", ".$end_t;
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
        return view('schedules.index');
    }

    public function getAbout() {

        date_default_timezone_set('America/New_York');

        // Update user information here
        $name = $_SERVER["HTTP_DISPLAYNAME"];
        $email = $_SERVER["HTTP_EMAIL"];
        $roles = array();
        $admin = new Admin();
        $resident = new Resident();
        $attending = new Attending();
        if ($admin->ifExist($email))
        {
            array_push($roles, "Admin");
        } 
        if ($resident->ifExist($email))
        {
            array_push($roles, "Resident");
        }

        // TODO: Update user schedule here
        $id = Resident::where('email', $_SERVER["HTTP_EMAIL"])->value('id');
        $date = self::calculateFirst();
        $firstday = null;

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
}

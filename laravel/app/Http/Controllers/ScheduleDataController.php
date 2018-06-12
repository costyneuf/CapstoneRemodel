<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScheduleData;
use App\Http\Controllers\Controller;

class ScheduleDataController extends Controller
{
    /*
            $table->increments('id');

            $table->date('date');
            $table->text('location');
            $table->text('room');
            $table->longText('case_procedure');
            $table->text('lead_surgeon');
            $table->longText('patient_class');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
    */
    
    private function getSchedule()
    {
        #This is all going to need to change
		$fp = fopen('../../../resources/Resident_Education_Report.20180612.csv', 'r');
		$data['schedule'] = new Schedule($fp);
		fclose($fp);
		$data['element_ids'] = ["Date", "Location", "Room", "Case Procedures", "Lead Surgeon", "Patient Class", "Proc Start", "Proj End Time"];
    }

    public function getFirstDay()
    {
        $year = date("o", strtotime('+1 day'));
        $mon = date('m',strtotime('+1 day'));
        $day = date('j',strtotime('+1 day'));
        if (date("l", strtotime('today'))=='Friday') {
            $year = date("o", strtotime('+3 day'));
            $mon = date('m',strtotime('+3 day'));
            $day = date('j',strtotime('+3 day'));
        }  

        // $schedule_data = DB::table('schedule_data')->select('date', $year.'-'.$mon.'-'.$day)->get();
        // return view('schedules.resident.viewschedule',compact('schedule_data', 'year', 'mon', 'day'));
        
        #This is all going to need to change
		$fp = fopen('../../../resources/Resident_Education_Report.20180612.csv', 'r');
		$data['schedule'] = new Schedule($fp);
		fclose($fp);
		$data['element_ids'] = ["Date", "Location", "Room", "Case Procedures", "Lead Surgeon", "Patient Class", "Proc Start", "Proj End Time"];
        
        return view('schedules.resident.table_generator',compact('year', 'mon', 'day', 'data'));
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

        // $schedule_data = DB::table('schedule_data')->select('date', $year.'-'.$mon.'-'.$day)->get();
        // return view('schedules.resident.viewschedule',compact('schedule_data', 'year', 'mon', 'day'));
		$fp = fopen('../../../resources/Resident_Education_Report.20180612.csv', 'r');
		$data['schedule'] = new Schedule($fp);
		fclose($fp);
		$data['element_ids'] = ["Date", "Location", "Room", "Case Procedures", "Lead Surgeon", "Patient Class", "Proc Start", "Proj End Time"];
        
        return view('schedules.resident.table_generator',compact('year', 'mon', 'day', 'data'));
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

        // $schedule_data = DB::table('schedule_data')->select('date', $year.'-'.$mon.'-'.$day)->get();
        // return view('schedules.resident.viewschedule',compact('schedule_data', 'year', 'mon', 'day'));
		$fp = fopen('../../../resources/Resident_Education_Report.20180612.csv', 'r');
		$data['schedule'] = new Schedule($fp);
		fclose($fp);
		$data['element_ids'] = ["Date", "Location", "Room", "Case Procedures", "Lead Surgeon", "Patient Class", "Proc Start", "Proj End Time"];
        
        return view('schedules.resident.table_generator',compact('year', 'mon', 'day', 'data'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResidentController extends Controller
{

    public function getIndex()
    {
        return view('schedules.resident.resident');
    }

    public function getInstructions()
	{
		return view('schedules.resident.instructions');
	}

	public function getSchedule()
	{		
		return view('schedules.resident.schedule');
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
        return view ('schedules.resident.viewschedule', compact('year', 'mon', 'day'));
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
        return view ('schedules.resident.viewschedule', compact('year', 'mon', 'day'));
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
        return view ('schedules.resident.viewschedule', compact('year', 'mon', 'day'));
    }
}

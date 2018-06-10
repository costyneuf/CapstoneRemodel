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
        $date = date("o", strtotime('+1 day')).date('m',strtotime('+1 day')).date('j',strtotime('+1 day'));
        if (date("l", strtotime('today'))=='Friday') {
            $date = date("o", strtotime('+3 day')).date('m',strtotime('+3 day')).date('j',strtotime('+3 day'));
        }      
        return view ('schedules.resident.viewschedule')->with('date', $date);
    }

    public function getSecondDay()
    {
        $date = date("o", strtotime('+2 day')).date('m',strtotime('+2 day')).date('j',strtotime('+2 day'));
        if (date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            $date = date("o", strtotime('+4 day')).date('m',strtotime('+4 day')).date('j',strtotime('+4 day'));
        }
        return view ('schedules.resident.viewschedule')->with('date', $date);
    }

    public function getThirdDay()
    {
        $date = date("o", strtotime('+3 day')).date('m',strtotime('+3 day')).date('j',strtotime('+3 day'));
        if (date("l", strtotime('today'))=='Wednesday' || date("l", strtotime('today'))=='Thursday' || date("l", strtotime('today'))=='Friday') {
            $date = date("o", strtotime('+5 day')).date('m',strtotime('+5 day')).date('j',strtotime('+5 day'));
        }
        return view ('schedules.resident.viewschedule')->with('date', $date);
    }
}

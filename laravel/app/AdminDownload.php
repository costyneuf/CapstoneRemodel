<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Admin;
use App\Resident;
use App\Attending;
use App\Assignment;
use App\Option;
use App\ScheduleData;

class AdminDownload extends Model
{
    public static function updateAccess()
    {
        $dir = __DIR__."/../../downloads/.htaccess";
        $fp = null;

        if (file_exists($dir)) {
            $fp = fopen($dir, 'w');
        } else {
            $fp = fopen($dir, 'c');
        }
        
        fwrite($fp, "ShibUseHeaders On\r\n");
        fwrite($fp, "AuthType shibboleth\r\n");
        fwrite($fp, "ShibRequestSetting redirectToSSL 443\r\n");
        fwrite($fp, "ShibRequestSetting requireSession 1\r\n");

        $admins = Admin::where('exists', '1')->get();

        foreach ($admins as $admin)
        {
            $line = "Require shib-user ".$admin['email']."\r\n";
            fwrite($fp, $line);
        }

        fclose($fp);

    }

    private static function updateResident()
    {        
        $dir = __DIR__."/../../downloads/resident.csv";
        $fp = null;

        if (file_exists($dir)) {
            $fp = fopen($dir, 'w');
        } else {
            $fp = fopen($dir, 'c');
        }

        fputcsv($fp, array('name', 'email'));
        $residents = Resident::where('exists', '1')->get();
        foreach ($residents as $resident)
        {
            fputcsv($fp, array($resident['name'], $resident['email']));   
        }
        fclose($fp);

    }

    private static function updateAttending()
    {        
        $dir = __DIR__."/../../downloads/attending.csv";
        $fp = null;

        if (file_exists($dir)) {
            $fp = fopen($dir, 'w');
        } else {
            $fp = fopen($dir, 'c');
        }

        fputcsv($fp, array('name', 'email'));
        $attendings = Attending::where('exists', '1')->get();
        foreach ($attendings as $attending)
        {
            fputcsv($fp, array($attending['name'], $attending['email']));   
        }
        fclose($fp);

    }

    private static function updateAdmin()
    {        
        $dir = __DIR__."/../../downloads/admin.csv";
        $fp = null;

        if (file_exists($dir)) {
            $fp = fopen($dir, 'w');
        } else {
            $fp = fopen($dir, 'c');
        }

        fputcsv($fp, array('name', 'email'));
        $admins = Admin::where('exists', '1')->get();
        foreach ($admins as $admin)
        {
            fputcsv($fp, array($admin['name'], $admin['email']));   
        }
        fclose($fp);

    }

    private static function updateOption()
    {        
        $dir = __DIR__."/../../downloads/option.csv";
        $fp = null;

        if (file_exists($dir)) {
            $fp = fopen($dir, 'w');
        } else {
            $fp = fopen($dir, 'c');
        }

        fputcsv($fp, array('date', 'room', 'patient class', 'start time', 'end time',
                            'lead surgeon', 'resident', 'preference', 'milestones', 'objectives'));
        $options = Option::orderBy('date', 'desc')->get();
        foreach ($options as $option)
        {
            $schedule_id = $option['schedule'];
            $resident_id = $option['resident'];

            $date = $option['date'];
            $room = ScheduleData::where('id', $schedule_id)->value('room');
            $patient_class = ScheduleData::where('id', $schedule_id)->value('patient_class');
            $start_time = ScheduleData::where('id', $schedule_id)->value('start_time');
            $end_time = ScheduleData::where('id', $schedule_id)->value('end_time');
            $lead_surgeon = ScheduleData::where('id', $schedule_id)->value('lead_surgeon');
            $resident = Resident::where('id', $resident_id)->value('name');
            $preference = $option['option'];
            $milestones = $option['milestones'];
            $objectives = $option['objectives'];

            fputcsv($fp, array($date, $room, $patient_class, $start_time, $end_time,
                            $lead_surgeon, $resident, $preference, $milestones, $objectives));   
        }
        fclose($fp);

    }

    private static function updateAssignment()
    {        
        $dir = __DIR__."/../../downloads/assignment.csv";
        $fp = null;

        if (file_exists($dir)) {
            $fp = fopen($dir, 'w');
        } else {
            $fp = fopen($dir, 'c');
        }

        fputcsv($fp, array('date', 'room', 'patient class', 'start time', 'end time', 'lead surgeon', 'resident'));
        $options = Assignment::orderBy('date', 'desc')->get();
        foreach ($options as $option)
        {
            $schedule_id = $option['schedule'];
            $resident_id = $option['resident'];

            $date = $option['date'];
            $room = ScheduleData::where('id', $schedule_id)->value('room');
            $patient_class = ScheduleData::where('id', $schedule_id)->value('patient_class');
            $start_time = ScheduleData::where('id', $schedule_id)->value('start_time');
            $end_time = ScheduleData::where('id', $schedule_id)->value('end_time');
            $lead_surgeon = ScheduleData::where('id', $schedule_id)->value('lead_surgeon');
            $resident = Resident::where('id', $resident_id)->value('name');

            fputcsv($fp, array($date, $room, $patient_class, $start_time, $end_time, $lead_surgeon, $resident));   
        }
        fclose($fp);

    }

    public static function updateFiles()
    {
        self::updateResident();
        self::updateAttending();
        self::updateAdmin();
        self::updateAssignment();
        self::updateOption();
    }
}

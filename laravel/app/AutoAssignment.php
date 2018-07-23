<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Option;
use App\Assignment;
use App\Resident;
use App\Probability;
use App\ScheduleData;

class AutoAssignment extends Model
{
    public static function assignment($date)
    {
        if (Option::where('date', $date)->doesntExist())
        {
            return;
        }

        /**
         * Get the ids of people who have completed selecting three options
         */
        $residents = Resident::orderBy('id', 'asc')->get();
        $candidates = array(); // Store duplicate first preference's schedule id
        foreach ($residents as $resident)
        {

            /**
             * Initialize probability if resident is not in probability table
             */
            if (Probability::where('resident', $resident['id'])->doesntExist())
            {
                Probability::insert([
                    'resident'=>$resident['id'], 'total'=>"0", 'selected'=>"0", 'probability'=>"0"
                ]);
            }

            if (Option::where('date', $date)->where('resident', $resident['id'])->count() == 3)
            {

                $firstPreference = Option::where('date', $date)->where('resident', $resident['id'])->where('option', "1")->value('schedule');
                if (Option::where('date', $date)->where('schedule', $firstPreference)->where('option', "1")->count() == 1)
                {
                    /**
                     * Add unique first preferences into database
                     */
                    self::addAssignment($firstPreference, $resident['id'], $date);
                    self::updateProbability($resident['id'], true);
                }
                else if (!in_array($firstPreference, $candidates)) {
                    array_push($candidates, $firstPreference);
                }
            }
        }

        /**
         * Assign OR based on the original probability
         */
        $remainder = array();
        foreach ($candidates as $candidate)
        {
            $competitors = Option::where('date', $date)->where('schedule', $candidate)->where('option', "1")->get();
            $minProb = 1;
            $toPush = null;
            foreach ($competitors as $competitor)
            {
                if ($minProb > Probability::where('resident', $competitor['resident'])->value('probability')){
                    $minProb = Probability::where('resident', $competitor['resident'])->value('probability');
                    if (!is_null($toPush))
                    {
                        array_push($remainder, $toPush);
                    }
                    $toPush = $competitor['resident'];
                }
                else
                {
                    array_push($remainder, $competitor['resident']);
                }
            }
            self::addAssignment($candidate, $toPush, $date);
            self::updateProbability($toPush, true);
        }

        /**
         * Assign OR for second and thrid preferences
         */
        foreach ($remainder as $other)
        {
            $choiceID = Option::where('date', $date)->where('resident', $other)->where('option', "2")->value('schedule');
            if (Assignment::where('schedule', $choiceID)->doesntExist())
            {
                self::addAssignment($choiceID, $other, $date);
                self::updateProbability($other, false);
            }
            else {
                $choiceID = Option::where('date', $date)->where('resident', $other)->where('option', "3")->value('schedule');
                if (Assignment::where('schedule', $choiceID)->doesntExist())
                {
                    self::addAssignment($choiceID, $other, $date);
                    self::updateProbability($other, false);
                }
                else {
                    /**
                     * Reset probability
                     */
                    Probability::where('resident', $other)->update([
                        'total'=>"0", 'selected'=>"0", 'probability'=>"0"
                    ]);
                }
            }
        }
        
    }

    private static function addAssignment($schedule, $resident, $date)
    {
        $attending = ScheduleData::where('id', $schedule)->value('lead_surgeon');
        $pos = strpos($attending, '[');
        $pos_end = strpos($attending, "]");
        $attending = substr($attending, $pos+1, $pos_end-$pos-1);

        Assignment::insert([
            'date'=>$date, 'resident'=>$resident, 'attending'=>$attending, 'schedule'=>$schedule
        ]);
    }

    private static function updateProbability($resident, $first)
    {
        $total = Probability::where('resident', $resident)->value('total') + 1;
        Probability::where('resident', $resident)->update([
            'total'=>$total
        ]);

        $selected = Probability::where('resident', $resident)->value('selected');
        if ($first)
        {
            $selected += 1;
            Probability::where('resident', $resident)->update([
                'selected'=>$selected
            ]);
        }

        $probability = $selected * 1.0 / $total;
        Probability::where('resident', $resident)->update([
            'probability'=>$probability
        ]);
    }
}

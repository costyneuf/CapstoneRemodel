<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constant;
use App\ScheduleData;

class ScheduleParser extends Model
{

	/**
	 * Protected members
	 */
	protected $filepath;
	protected $date;

	/**
	 * Private functions
	 */

	/**
	 * Parse date
	 * 
	 * @var string
	 */
	private static function getLineDate($line)
	{

		$month = intval(substr($line[Constant::DATE], 0, 2));
		$day = intval(substr($line[Constant::DATE], 3, 5));
		$year = intval(substr($line[Constant::DATE], 6));
		
		return ($year."-".$month."-".$day);
	}

	/**
	 * Parse time
	 * 
	 * @var string
	 * 
	 * @var int
	 * 
	 */
	private static function getLineTime($line, $index)
	{

		if (strcmp($line[$index], "") == 0) return null;
		$hourInt = intval(substr($line[$index], 0, 2));
		$minuteInt = intval(substr($line[$index], 2));
		
		return ($hourInt.":".$minuteInt.":00");
	}

	/**
	 * Insert data into database.
	 */
	private function insertScheduleData()
	{
		/**
		 * Open file
		 */
		$fp = fopen($this->filepath, 'r');

		/**
		 * Read the first row
		 */
		fgetcsv($fp);
		
		while (($line = fgetcsv($fp)) !== false)
		{
			$date = self::getLineDate($line);
			$location = $line[Constant::LOCATION];
			$room = $line[Constant::ROOM];
			$case_procedure = $line[Constant::CASE_PROCEDURE];
			$lead_surgeon = $line[Constant::LEAD_SURGEON];
			$patient_class = $line[Constant::PATIENT_CLASS];
			$start_time = self::getLineTime($line, Constant::START_TIME);
			$end_time = self::getLineTime($line, Constant::END_TIME);

			ScheduleData::insert(
				['date' => $date, 'location' => $location, 'room' => $room, 'case_procedure' => $case_procedure, 
				'lead_surgeon' => $lead_surgeon, 'patient_class' => $patient_class, 'start_time' => $start_time, 
				'end_time' => $end_time]
			);
		}

		/**
		 * Close file
		 */
		fclose($fp);

	}

	
	/**
	 * Public functions
	 */
	
	/**
	 * Constructor of ScheduleBuffer.
	 * 
	 * @var string
	 * 		{@code date} Formate: "year" + "month" + "day"
	 */
    public function __construct($datefile, $isConsole=false)
	{	
		$this->filepath = $isConsole ? Constant::CONSOLE_PATH.$datefile.Constant::EXTENSION 
							:Constant::WEB_PATH.$datefile.Constant::EXTENSION;

		/**
		 * Assign value to date
		 */
		$year = intval(substr($datefile, 0, 4));
		$month = intval(substr($datefile, 4, 6));
		$day = intval(substr($datefile, 6));
		$this->date = $year."-".$month."-".$day;

		$this->insertScheduleData();
	}

	/**
	 * Combine data row with same date and room
	 */
	public function processScheduleData($date)
	{
		$data_arr = ScheduleData::where('date', $date)
								->orderBy('room', 'asc')
								->get();

								
		for($i = 0; $i < count($data_arr) - 1; $i++)
		{
			if ($data_arr[$i]['room'] == $data_arr[$i + 1]['room'])
			{

				/**
				 * Updates $data_arr[$i + 1]
				 */
				if($data_arr[$i]['start_time'] == null || $data_arr[$i]['start_time'] < $data_arr[$i + 1]['start_time'])
				{
					ScheduleData::where('id', $data_arr[$i + 1]['id'])
								->update(['start_time'=> $data_arr[$i]['start_time']]);
				}
				if($data_arr[$i]['end_time'] == null || $data_arr[$i]['end_time'] > $data_arr[$i + 1]['end_time'])
				{
					ScheduleData::where('id', $data_arr[$i + 1]['id'])
								->update(['end_time'=> $data_arr[$i]['end_time']]);
				}
				$case_procedure = $data_arr[$i]['case_procedure'].", ".$data_arr[$i+1]['case_procedure'];
				ScheduleData::where('id', $data_arr[$i + 1]['id'])
							->update(['case_procedure'=> $case_procedure]);


				// Delete data query
				ScheduleData::where('id', $data_arr[$i]['id'])->delete();
			}
		}
	}
    
}

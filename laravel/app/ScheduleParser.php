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

		if (strcmp($line[$index], "") == 0) return "";
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
    public function __construct($datefile)
	{	
		$this->filepath = Constant::PATH.$datefile.Constant::EXTENSION;

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
	public function processScheduleData()
	{
		$this->insertScheduleData();

		$data_arr = ScheduleData::whereDate('date', '>', $this->$date)
								->orderBy('room', 'asc')
								->get();
		$remove_id_arr = [];

		for($i = 1; $i < count($data_arr); $i++)
		{
			//if ($data_arr[$i])
		}
	}
    
}

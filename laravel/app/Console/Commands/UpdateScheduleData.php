<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Constant;

class UpdateScheduleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:schedule_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the file name
        $today = getdate();
        $year = $today['year'];
        $month = $today['mon'] >= 10 ? $today['mon'] : '0'.$today['mon'];
        $day = $today['mday'] >= 10 ? $today['mday'] : '0'.$today['mday'];
        $file_string = CONSTANT::WEB_PATH.$year.$month.$day.CONSTANT::EXTENSION;
        
        $fp = fopen($file_string, 'r');       
        fgetcsv($fp);
        while (($line = fgetcsv($fp)) !== false)
        {
            // Create a new item
            $schedule = new \App\ScheduleData();

            /* 
             * TODO: Insert data 
             *      Combine different rows w/ the same room option
             *      Ignore data w/ incomplete information
             */
           
            // Save data inserted
            $schedule->save();

        }

        fclose($fp);

    }
}

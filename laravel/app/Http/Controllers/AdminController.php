<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Attending;
use App\Resident;
use App\Option;
use App\Assignment;
use App\AdminDownload;
use App\ScheduleData;

class AdminController extends Controller
{   
    public function getIndex()
    {         
        return view('schedules.admin.admin');        
    }

    /**
     * Parse data sets of residents, attendings, and admins to users page
     */
    public function getUsers()
    {
        $resident = Resident::where('exists', '1')->orderBy('email', 'asc')->get();
        $admin = Admin::where('exists', '1')->orderBy('email', 'asc')->get();
        $attending = Attending::where('exists', '1')->orderBy('email', 'asc')->get();
        $roles = array();
        
        for ($i=0; $i<count($admin); $i++) {
            $role = array(
                'name'=>$admin[$i]['name'],
                'email'=>$admin[$i]['email'],
                'role'=>"Admin"
            );
            array_push($roles, $role);
        }
        
        for ($i=0; $i<count($attending); $i++) {
            $role = array(
                'name'=>$attending[$i]['name'],
                'email'=>$attending[$i]['email'],
                'role'=>"Attending"
            );
            array_push($roles, $role);
        }
        
        for ($i=0; $i<count($resident); $i++) {
            $role = array(
                'name'=>$resident[$i]['name'],
                'email'=>$resident[$i]['email'],
                'role'=>"Resident"
            );
            array_push($roles, $role);
        }

        return view('schedules.admin.users', compact('roles'));
    }

    /**
     * Route to update user page
     */
    public function getUpdateUsers($op, $role, $email, $flag, $name=null)
    {
        if ($name == null) {
            $name = "null";
        }
        
        str_replace("%20", " ", $name);
        
        $data = array(
            'op'=>$op,
            'role'=>$role,
            'email'=>$email,
            'flag'=>$flag,
            'name'=>$name
        );
        
        /**
         * If the data input has not been confirmed, route user to a confirmation page.
         */
        if (strcmp($flag, "false") == 0) {
            return view('schedules.admin.users_confirm', compact('data'));
        } 
        
        /**
         * Update admin
         */
        if (strcmp($role, "Admin") == 0) {
            /**
             * Delete admin, switch 'exists' to false
             */
            if (strcmp($op, "deleteUser") == 0) {
                Admin::where('email', $email)->update(['exists'=> '0']);
            }
            
            /**
             * Add a new admin
             */
            else if (strcmp($op, "addUser") == 0 && Admin::where('email', $email)->doesntExist()) {
                Admin::insert(['name'=>$name, 'email'=>$email]);
            } 
            
            /**
             * Add an old admin, switch 'exists' to true
             */
            else if (strcmp($op, "addUser") == 0 && Admin::where('email', $email)->exists()) {
                Admin::where('email', $email)->update(['exists'=> '1']);
            }
        }
        
        /**
         * Update attending
         */
        else if (strcmp($role, "Attending") == 0) {
            /**
             * Delete attending, switch 'exists' to false
             */
            if (strcmp($op, "deleteUser") == 0) {
                Attending::where('email', $email)->update(['exists'=> '0']);
            } 

            /**
             * Add a new attending
             */
            else if (strcmp($op, "addUser") == 0 && Attending::where('email', $email)->doesntExist()) {
                $id = substr($name, strpos($name, "<")+1, strpos($name, ">")-strpos($name, "<")-1);
                $name_ = substr($name, 0, strpos($name, "<"));
                Attending::insert(['name'=>$name_, 'email'=>$email, 'id'=>$id]);
            }
            
            /**
             * Add an old attending, switch 'exists' to true
             */
            else if (strcmp($op, "addUser") == 0 && Attending::where('email', $email)->exists()) {
                Attending::where('email', $email)->update(['exists'=> '1']);
            }
        } 

        /**
         * Update resident
         */
        else if (strcmp($role, "Resident") == 0) {
            /**
             * Delete resident, switch 'exists' to false
             */            
            if (strcmp($op, "deleteUser") == 0) {
                Resident::where('email', $email)->update(['exists'=> '0']);
            }             
            
            /**
             * Add a new resident
             */
            else if (strcmp($op, "addUser") == 0 && Resident::where('email', $email)->doesntExist()) {
                Resident::insert(['name'=>$name, 'email'=>$email]);
            } 
           
            /**
             * Add an old admin, switch 'exists' to true
             */
            else if (strcmp($op, "addUser") == 0 && Resident::where('email', $email)->exists()) {
                Resident::where('email', $email)->update(['exists'=> '1']);
            }
        }
        
        return view('schedules.admin.users_update');
    }

    /**
     * Route to update schedule page
     */
    public function getSchedules()
    {
        return view('schedules.admin.schedules');
    }


    /**
     * Route to update DB page
     */
    public function postUpdateDB()
    {
        if (strcmp($_POST['op'], "add") == 0)
        {
            $date = $_POST['date'];
            return view('schedules.admin.addDB', compact('date'));
        } 
        else if (strcmp($_POST['op'], "delete") == 0)
        {
            /**
             * Back up data sheets
             */
            AdminDownload::updateAccess();
            $urls = AdminDownload::updateURL($_POST['date']);
            
            if ($urls !== null)
            {

                /**
                 * Delete selected data sets
                 */
                Assignment::where('date', $_POST['date'])->delete();
                Option::where('date', $_POST['date'])->delete();
                ScheduleData::where('date', $_POST['date'])->delete();

                return view('schedules.admin.deleteDB', compact('urls'));
            }

            echo "Error in deleting data sets!";
        } 
        else if (strcmp($_POST['op'], "edit") == 0)
        {
            $datasets = self::retrieveData($_POST['date']);
            $residents = Resident::orderBy('email', 'asc')->get();
            return view('schedules.admin.editDB', compact('datasets', 'residents'));            
        }

    }

    private function retrieveData($date)
    {
        $schedules = ScheduleData::where('date', $date)->orderBy('room', 'asc')->get();
        $datasets = array();

        foreach ($schedules as $schedule)
        {
            $id = $schedule['id'];
            $location = is_null($schedule['location']) ? "" : $schedule['location'];
            $room = is_null($schedule['room']) ? "" : $schedule['room'];
            $case_procedure = is_null($schedule['case_procedure']) ? "" : $schedule['case_procedure'];
            
            $lead_surgeon = "";
            $lead_surgeon_code = "";
            if (!is_null($schedule['lead_surgeon']))
            {
                $pos = strpos($schedule['lead_surgeon'], "[");
                $pos_end = strpos($schedule['lead_surgeon'], "]");
                $lead_surgeon = substr($schedule['lead_surgeon'], 0, $pos-1);
                $lead_surgeon_code = substr($schedule['lead_surgeon'], $pos+1, $pos_end-$pos-1);
            }

            $patient_class = is_null($schedule['patient_class']) ? "" : $schedule['patient_class'];
            $start_time = is_null($schedule['start_time']) ? "" : $schedule['start_time'];
            $end_time = is_null($schedule['end_time']) ? "" : $schedule['end_time'];
            
            $assignment = "";
            $email = "";
            if (Assignment::where('schedule', $id)->exists())
            {
                $resident = Assignment::where('schedule', $id)->value('resident');
                $assignment = Resident::where('id', $resident)->value('name');
                $email = Resident::where('id', $resident)->value('email');
            }

            array_push($datasets, array(
                        'id'=>$id, 'location'=>$location, 'room'=>$room, 'date'=>$date,
                        'case_procedure'=>$case_procedure, 'lead_surgeon'=>$lead_surgeon,
                        'lead_surgeon_code'=>$lead_surgeon_code, 'patient_class'=>$patient_class,
                        'start_time'=>$start_time, 'end_time'=>$end_time, 'assignment'=>$assignment, 'email'=>$email
            ));

        }
        return $datasets;
    }

    private function processCaseProcedure($case_procedure_1=null)
    {
        $case_procedure = is_null($case_procedure_1) ? $_POST['case_procedure_1']." [".$_POST['case_procedure_1_code']."]" : $case_procedure_1;
        if (strlen($_POST['case_procedure_2'])>0)
        {
            if (strlen($case_procedure) > 0) {
                $case_procedure.=", ".$_POST['case_procedure_2']." [".$_POST['case_procedure_2_code']."]";
            } else {
                $case_procedure.=$_POST['case_procedure_2']." [".$_POST['case_procedure_2_code']."]";
            }
            
            if (strlen($_POST['case_procedure_3'])>0)
            {
                $case_procedure.=", ".$_POST['case_procedure_3']." [".$_POST['case_procedure_3_code']."]";
                if (strlen($_POST['case_procedure_4'])>0)
                {
                    $case_procedure.=", ".$_POST['case_procedure_4']." [".$_POST['case_procedure_4_code']."]";
                    if (strlen($_POST['case_procedure_5'])>0)
                    {
                        $case_procedure.=", ".$_POST['case_procedure_5']." [".$_POST['case_procedure_5_code']."]";
                        
                    }
                }
            }
            
        }

        return $case_procedure;
    }

    /**
     * Route to add DB page
     */
    public function postAddDB()
    {

        $message = "Fail to add schedule data!";

        if (ScheduleData::where('date', $_POST['date'])->where('room', $_POST['room'])->doesntExist())
        {
            $date = $_POST['date'];
            $location = $_POST['location'];
            $room = $_POST['room'];
            $case_procedure = self::processCaseProcedure();
            $lead_surgeon = $_POST['lead_surgeon']." [".$_POST['lead_surgeon_code']."]";
            $patient_class = $_POST['patient_class'];
            $start_time = $_POST['start_time'].":00";
            $end_time = $_POST['end_time'].":00";
            if (strcmp($start_time, $end_time) < 0) {
                ScheduleData::insert([
                    'date' => $date, 'location' => $location, 'room' => $room, 'case_procedure' => $case_procedure, 
                    'lead_surgeon' => $lead_surgeon, 'patient_class' => $patient_class, 'start_time' => $start_time, 
                    'end_time' => $end_time
                ]);
    
                $message = "Successfully add schedule data!";
            }

        }

        return view('schedules.admin.addDB_OK', compact('message'));
    }

    public function postEditDB()
    {
        $message = "Fail to edit schedule data!";
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        if (strcmp($start_time, $end_time) < 0) {
            $id = $_POST['id'];
            $location = $_POST['location'];
            $room = $_POST['room'];
            $case_procedure = self::processCaseProcedure($_POST['case_procedure_1']);
            $lead_surgeon = $_POST['lead_surgeon']." [".$_POST['lead_surgeon_code']."]";
            $patient_class = $_POST['patient_class'];
            
            ScheduleData::where('id', $id)->update([
                'location' => $location, 'room' => $room, 'case_procedure' => $case_procedure, 
                'lead_surgeon' => $lead_surgeon, 'patient_class' => $patient_class, 
                'start_time' => $start_time, 'end_time' => $end_time
            ]);

            if (strlen($_POST['assignment']) > 0 && Assignment::where('schedule', $id)->exists())
            {
                $assignment = Resident::where('email', $_POST['assignment'])->value('id');
                Assignment::where('schedule', $id)->update([
                    'resident'=>$assignment
                ]);
            }
            elseif (strlen($_POST['assignment']) > 0)
            {
                $assignment = Resident::where('email', $_POST['assignment'])->value('id');
                $date = $_POST['date'];
                Assignment::insert([
                    'date'=>$date, 'resident'=>$assignment, 
                    'attending'=>$_POST['lead_surgeon_code'],
                    'schedule'=>$id, 
                ]);
            }


            $message = "Successfully edit schedule data!";
        }

 

        return view('schedules.admin.addDB_OK', compact('message'));
    }
    


    /**
     * Route to post messages page
     */
    public function getMessages()
    {
        return view('schedules.admin.messages');
    }

    /**
     * Route to download data sheets page
     */
    public function getDownload()
    {
        AdminDownload::updateAccess();
        AdminDownload::updateFiles();
        return view('schedules.admin.download');
    }

}

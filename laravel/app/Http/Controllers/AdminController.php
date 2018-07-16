<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Attending;
use App\Resident;
use App\Option;
use App\Assignment;
use App\AdminDownload;

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

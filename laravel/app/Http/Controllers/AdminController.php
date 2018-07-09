<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Attending;
use App\Resident;

class AdminController extends Controller
{   
    public function getIndex()
    {         
        $email = $_SERVER["HTTP_EMAIL"];
        $admin = new Admin();
        if ($admin->ifExist($email))
        {
            return view('schedules.admin.admin');
        }

        return view('nonpermit');
        
    }

    /**
     * Parse data sets of residents, attendings, and admins to users page
     */
    public function getUsers()
    {
        $resident = Resident::orderBy('email', 'asc')->get();
        $admin = Admin::orderBy('email', 'asc')->get();
        $attending = Attending::orderBy('email', 'asc')->get();
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

    public function getUpdateUsers($op, $role, $email, $flag, $name=null)
    {
        if ($name == null) {
            $name = "null";
        }
        $data = array(
            'op'=>$op,
            'role'=>$role,
            'email'=>$email,
            'flag'=>$flag,
            'name'=>$name
        );
        if (strcmp($flag, "false") == 0) {
            return view('schedules.admin.users_confirm', compact('data'));
        } 
        if (strcmp($role, "Admin") == 0) {
            if (strcmp($op, "deleteUser") == 0) {
                Admin::where('email', $email)->delete();
            } else if (strcmp($op, "addUser") == 0 && Admin::where('email', $email)->count() == 0) {
                Admin::insert(['name'=>$name, 'email'=>$email]);
            } 
        } else if (strcmp($role, "Attending") == 0) {
            if (strcmp($op, "deleteUser") == 0) {
                Attending::where('email', $email)->delete();
            } else if (strcmp($op, "addUser") == 0 && Attending::where('email', $email)->count() == 0) {
                Attending::insert(['name'=>$name, 'email'=>$email]);
            } 
        } else if (strcmp($role, "Resident") == 0) {
            if (strcmp($op, "deleteUser") == 0) {
                Resident::where('email', $email)->delete();
            } else if (strcmp($op, "addUser") == 0 && Resident::where('email', $email)->count() == 0) {
                Resident::insert(['name'=>$name, 'email'=>$email]);
            } 
        }
        return view('schedules.admin.users_update');
    }

    public function getSchedules()
    {

    }

    public function getMessages()
    {

    }

}

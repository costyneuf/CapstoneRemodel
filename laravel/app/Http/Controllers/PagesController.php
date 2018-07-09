<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Resident;
use App\Attending;

class PagesController extends Controller
{

    public function getIndex()
    {
        return view('schedules.index');
    }

    public function getAbout() {

        // Update user information here
        $name = $_SERVER["HTTP_DISPLAYNAME"];
        $email = $_SERVER["HTTP_EMAIL"];
        $roles = array();
        $admin = new Admin();
        $resident = new Resident();
        $attending = new Attending();
        if ($admin->ifExist($email))
        {
            array_push($roles, "Admin");
        } else if ($resident->ifExist($email))
        {
            array_push($roles, "Resident");
        }

        // TODO: Update user schedule here
        $firstday = null;
        $secondday = array(
                        "first"=>null,
                        "second"=>null,
                        "thrid"=>null
        );
        $thirdday = array(
            "first"=>null,
            "second"=>null,
            "thrid"=>null
        );

        // Parse data into array
        $data = array(
                    "name"=>$name,
                    "email"=>$email,
                    "roles"=>$roles,
                    "firstday"=>$firstday,
                    "secondday"=>$secondday,
                    "thirdday"=>$thirdday
        );

        return view('pages.about', compact('data'));
    }
    
    public function getContact() {
        return view('pages.contact');
    }
}

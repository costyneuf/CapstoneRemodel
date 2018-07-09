<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    /**
     * Check whether the user is in the system.
     * 
     * @var string
     */
    public function ifExist($email)
    {
        if (self::where('email', $email)->count() > 0) {
            return true;
         }
         return false;
    }
}

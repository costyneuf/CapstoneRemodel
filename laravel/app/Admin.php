<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Roles;

class Admin extends Roles
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}

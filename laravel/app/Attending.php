<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Roles;

class Attending extends Roles
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attending';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

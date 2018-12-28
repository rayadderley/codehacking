<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    /**
     * Relationship One-To-Many from User to Role
     */
    public function users(){
        return $this->hasMany('App\User');
    }
}

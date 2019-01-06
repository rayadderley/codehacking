<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * One Role has many User
     */
    public function users(){
        return $this->hasMany('App\User');
    }
}

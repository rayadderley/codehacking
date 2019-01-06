<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'is_active', 'photo_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship - 1:1 from User to Role
     */
    public function role(){
        return $this->belongsTo('App\Role');
    }

    /**
     * Relationship - 1:1 from User to Photo
     */
    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    /**
     * Check if the user is admin & active for security in Middleware
     */
    public function isAdmin(){
        if($this->role->name == "administrator" && $this->is_active == 1){
            return true;
        }

        return false;
    }

    /**
     * One User has many posts 
     */
    public function posts(){
        return $this->hasMany('App\Post');
    }
}

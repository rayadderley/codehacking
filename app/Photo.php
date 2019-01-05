<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //

    protected $uploads = '/images/';

    protected $fillable = ['file'];

    /**
     *  getFileAttribute() = file is the name of the column inside Photo table in database
     *  The accessor for image folder
     * */  
    public function getFileAttribute($photo){
        return $this->uploads . $photo;
    }
}

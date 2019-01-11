<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'category_id',
        'photo_id',
        'title',
        'body'
    ];

    /**
     * One Post has a user
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * One Post has a photo
     */
    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    /**
     * One Post has a category
     */
    public function category(){
        return $this->belongsTo('App\Category');
    }

    /**
     * One Post has many comments
     */
    public function comments(){
        return $this->hasMany('App\Comment');
    }
}

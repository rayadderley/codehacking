<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'post_id',
        'author',
        'email',
        'body',
        'is_active'
    ];

    /**
     * A Comment has many CommentReply
     */
    public function replies(){
        return $this->hasMany('App\CommentReply');
    }

    /**
     * A comment belongs to a Post
     */
    public function post(){
        return $this->belongsTo('App\Post');
    }
}

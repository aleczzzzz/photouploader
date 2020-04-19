<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Photo extends Model
{
    protected $fillable = [
        'name', 'caption', 'user_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    //get photo path
    public function getPathAttribute()
    {
        return Storage::url('photos/' . $this->user_id . '/' . $this->name);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'photo_id', 'id');
    }

    public function likers()
    {
        return $this->belongsToMany('App\User', 'likers');
    }
}

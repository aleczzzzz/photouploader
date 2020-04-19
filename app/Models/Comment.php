<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment', 'user_id', 'photo_id'
    ];

    protected $dates = [
        'created_by', 'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo', 'photo_id', 'id');
    }
}

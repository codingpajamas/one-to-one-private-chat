<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['channel_id', 'user_id', 'body'];

    public function channel()
    {
    	return $this->belongsTo('App\Channel');
    }

    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}

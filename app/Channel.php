<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['channel_name', 'alias_name', 'sender_id', 'receiver_id', 'sender_status', 'receiver_status'];

    public function sender()
    {
    	return $this->belongsTo('App\User', 'sender_id');
    }

    public function receiver()
    {
    	return $this->belongsTo('App\User', 'receiver_id');
    }

    public function conversations()
    {
    	return $this->hasMany('App\Conversation');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'Member';
    protected $fillable = [];
    protected $hidden = [];

    protected static $userModel = 'Cartalyst\Sentinel\Users\EloquentUser';
    protected static $takeModel = 'App\Models\Take';

    public function user () {
    	return $this->belongsTo(static::$userModel, 'user_id');
    }

    public function takes () {
    	return $this->hasMany(static::$takeModel, 'member_id');
    }
}
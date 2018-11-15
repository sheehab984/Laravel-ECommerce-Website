<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function addresses()
    {
    	return $this->hasMany('App\Address', 'id', 'address_id');
    }
}

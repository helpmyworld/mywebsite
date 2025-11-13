<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function type(){
    	return $this->hasMany('App\Type','parent_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manuscript extends Model
{
    protected $fillable = [
        'title','status','file_name','user_id'
    ];

    public function generateRandomName($title,$value) {
        $filename = replaceWhiteSpace($title).date('m-d-Y_hia') . '.' . $value->getClientOriginalExtension();
        return $filename;
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function replaceWhiteSpace($text){

        $new_phone =str_replace(' ','_',$text);
        $new_phone = trim(preg_replace('/(?![ ])\s+/', '_', $new_phone));

        return $new_phone;
    }
}

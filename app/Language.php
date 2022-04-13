<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $table = "language";

    public $fillable = ['id','dir','name','avatar',
        'select',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function avatar(){
        return url('/').env('PATH_IMAGE').$this->avatar;
    }
}

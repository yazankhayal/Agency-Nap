<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvBlock extends Model
{
    public $table = "adv_block";

    public $fillable = ['id','hours',
        'phone',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

}

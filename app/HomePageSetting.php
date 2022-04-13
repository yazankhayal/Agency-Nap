<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    public $table = "homepage_setting";

    public $fillable = ['id',
        'name',
        'services_id',
        'name','price',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';
}

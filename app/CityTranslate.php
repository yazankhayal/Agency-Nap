<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityTranslate extends Model
{
    public $table = "city_translate";

    public $fillable = ['id','name',
        'summary',
        'language_id',
        'city_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function City(){
        return $this->belongsTo(City::class,"city_id","id");
    }

}

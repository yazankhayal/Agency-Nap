<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingTranslate extends Model
{
    public $table = "setting_translate";

    public $fillable = ['id','name',
        'setting_id',
        'language_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Setting(){
        return $this->belongsTo(Setting::class,"setting_id","id");
    }
}

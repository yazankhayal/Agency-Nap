<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentsTranslate extends Model
{
    public $table = "hp_contents_translate";

    public $fillable = ['id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function About(){
        return $this->belongsTo(Contents::class,"hp_contents_id","id");
    }

}

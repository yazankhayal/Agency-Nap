<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HPWordsTranslate extends Model
{
    public $table = "hp_words_translate";

    public $fillable = ['id','home',
        'hp_words_id',
        'language_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function HPWords(){
        return $this->belongsTo(HPWords::class,"hp_words_id","id");
    }


}

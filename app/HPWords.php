<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HPWords extends Model
{
    public $table = "hp_words";

    public $fillable = ['id','home',
        'about',
        'products',
        'services',
        'blog',
        'contact',
        'language_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function SettingTranslate(){
        return $this->hasOne(HPWordsTranslate::class,"hp_words_id","id");
    }

    public function Translate($i){
        return $this->hasOne(HPWordsTranslate::class,"hp_words_id","id")
            ->where('language_id','=',$i)->first();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact_page extends Model
{
    public $table = "hp_contents";

    public $fillable = ['id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Translate($i){
        return $this->hasOne(Contact_pageTranslate::class,"hp_contents_id","id")
            ->where('language_id','=',$i)->first();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact_pageTranslate extends Model
{
    public $table = "hp_contents_translate";

    public $fillable = ['id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Contact_page(){
        return $this->belongsTo(Contact_page::class,"hp_contents_id","id");
    }

}

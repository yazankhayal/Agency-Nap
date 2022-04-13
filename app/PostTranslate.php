<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTranslate extends Model
{
    public $table = "post_translate";

    public $fillable = ['id','name',
        'summary',
        'language_id',
        'post_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Post(){
        return $this->belongsTo(Post::class,"post_id","id");
    }

}

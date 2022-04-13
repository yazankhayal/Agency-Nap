<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestimonialsTranslate extends Model
{
    public $table = "testimonials_translate";

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

    public function Testimonials(){
        return $this->belongsTo(Testimonials::class,"testimonials_id","id");
    }

}

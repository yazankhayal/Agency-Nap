<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslate extends Model
{
    public $table = "category_translate";

    public $fillable = ['id','name',
        'summary',
        'language_id',
        'category_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Category(){
        return $this->belongsTo(Category::class,"category_id","id");
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsTranslate extends Model
{
    public $table = "products_translate";

    public $fillable = ['id','name','summary',
        'products_id',
        'language_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Products(){
        return $this->belongsTo(Products::class,"products_id","id");
    }

}

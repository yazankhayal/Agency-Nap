<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    public $table = "products_request";

    public $fillable = ['id','summary','name','phone',
        'email',
        'products_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Products(){
        return $this->belongsTo(Products::class,"products_id","id");
    }

}

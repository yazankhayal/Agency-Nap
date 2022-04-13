<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $table = "gallery";

    public $fillable = ['id',
        'products_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function img(){
        return url('/').env('PATH_IMAGE').'upload/gallery/'.$this->avatar;
    }

}

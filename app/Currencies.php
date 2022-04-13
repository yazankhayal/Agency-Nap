<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    public $table = "currencies";

    public $fillable = ['id','name',
        'code',
        'avatar',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function CurrencyConversions(){
        return $this->hasOne(CurrencyConversions::class,"currencies_id","id");
    }
}

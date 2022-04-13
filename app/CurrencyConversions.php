<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyConversions extends Model
{
    public $table = "currency_conversions";

    public $fillable = ['id','price',
        'currencies_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function currencie(){
        return $this->belongsTo(Currencies::class,"currencies_id","id");
    }

}

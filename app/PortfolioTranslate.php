<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioTranslate extends Model
{
    public $table = "portfolio_translate";

    public $fillable = ['id','name','summary',
        'products_id',
        'language_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function Portfolio(){
        return $this->belongsTo(Portfolio::class,"portfolio_id","id");
    }

}

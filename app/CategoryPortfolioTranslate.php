<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPortfolioTranslate extends Model
{
    public $table = "category_portfolio_translate";

    public $fillable = ['id','name',
        'summary',
        'language_id',
        'category_portfolio',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function CategoryPortfolio(){
        return $this->belongsTo(CategoryPortfolio::class,"category_portfolio_id","id");
    }

}

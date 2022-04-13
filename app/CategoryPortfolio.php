<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPortfolio extends Model
{
    public $table = "category_portfolio";

    public $fillable = ['id','name',
        'type',
        'summary',
        'avatar',
        'language_id',
        'user_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function User(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function CategoryPortfolio(){
        return $this->hasMany(CategoryPortfolioTranslate::class,"category_portfolio_id","id");
    }

    public function Portfolio(){
        return $this->hasMany(Portfolio::class,"category_portfolio_id","id");
    }

    public function Translate($i){
        return $this->hasOne(CategoryPortfolioTranslate::class,"category_portfolio_id","id")
            ->where('language_id','=',$i)->first();
    }
    public function select_lang(){
        return  $select_lan_choice = Language::where('select', '=', '1')->first();
    }

    public function select_lan(){
        $select_lan = Language::where('dir', '=', app()->getLocale())->first();
        if ($select_lan == null) {
            $select_lan = Language::where('select', '=', '1')->first();
        }
        return $select_lan;
    }

    public function name(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->name;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->name : "";
        }
    }

    public function route_products(){
       return route('products',['category_portfolio'=>$this->id]);
    }

    public function avatar(){
        return env('PATH_IMAGE').$this->avatar;
    }
}

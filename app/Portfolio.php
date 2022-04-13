<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cookie;

class Portfolio extends Model
{
    public $table = "portfolio";

    public $fillable = ['id', 'name',
        'avatar', 'summary',
        'language_id',
        'category_portfolio_id',
        'created_at', 'updated_at'];

    public $dates = ['created_at', 'updated_at'];
    public $primaryKey = 'id';

    public function User()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function Language()
    {
        return $this->belongsTo(Language::class, "language_id", "id");
    }

    public function PortfolioTranslate()
    {
        return $this->hasMany(PortfolioTranslate::class, "portfolio_id", "id");
    }

    public function CategoryPortfolio()
    {
        return $this->belongsTo(CategoryPortfolio::class, "category_portfolio_id", "id");
    }

    public function Translate($o2)
    {
        return $this->hasOne(ProductsTranslate::class, "products_id", "id")
            ->where('language_id', '=', $o2)->first();
    }

    public function select_lang()
    {
        return $select_lan_choice = Language::where('select', '=', '1')->first();
    }

    public function Translatex(){
        return $this->hasMany(ProductsTranslate::class,"products_id","id");
    }

    public function select_lan()
    {
        $select_lan = Language::where('dir', '=', app()->getLocale())->first();
        if ($select_lan == null) {
            $select_lan = Language::where('select', '=', '1')->first();
        }
        return $select_lan;
    }

    public function CurrentTranslate()
    {
        return $this->hasMany(ProductsTranslate::class, "products_id", "id");
    }

    public function name()
    {
        if (app()->getLocale() == $this->select_lang()->dir) {
            return $this->name;
        } else {
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->name : "";
        }
    }

    public function sub_name()
    {
        if (app()->getLocale() == $this->select_lang()->dir) {
            return $this->sub_name;
        } else {
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->sub_name : "";
        }
    }

    public function img()
    {
        return url('/') . env('PATH_IMAGE') . $this->avatar;
    }

    public function route(){
        return route('portfolio',['category_id'=>$this->id]);
    }
}

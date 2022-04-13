<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cookie;

class Products extends Model
{
    public $table = "products";

    public $fillable = ['id', 'name',
        'avatar', 'summary',
        'language_id',
        'category_id',
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

    public function Category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function Products()
    {
        return $this->hasMany(ProductsTranslate::class, "products_id", "id");
    }

    public function Translate($o2)
    {
        return $this->hasOne(ProductsTranslate::class, "products_id", "id")
            ->where('language_id', '=', $o2)->first();
    }

    public function ProductsGellery()
    {
        return $this->hasMany(ProductsGellery::class, "products_id", "id");
    }

    public function Review()
    {
        return $this->hasOne(ProductsReview::class, "products_id", "id");
    }

    public function Reviews()
    {
        return $this->hasMany(ProductsReview::class, "products_id", "id");
    }

    public function select_lang()
    {
        return $select_lan_choice = Language::where('select', '=', '1')->first();
    }

    public function Translatex(){
        return $this->hasMany(ProductsTranslate::class,"products_id","id");
    }

    public function date(){
        return date_format($this->created_at,'d m,Y');
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

    public function summary()
    {
        if (app()->getLocale() == $this->select_lang()->dir) {
            return $this->summary;
        } else {
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->summary : "";
        }
    }

    public function summary1()
    {
        if (app()->getLocale() == $this->select_lang()->dir) {
            return $this->summary1;
        } else {
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->summary1 : "";
        }
    }

    public function sub_summary()
    {
        if (app()->getLocale() == $this->select_lang()->dir) {
            return $this->sub_summary;
        } else {
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->sub_summary : "";
        }
    }

    public function img()
    {
        return url('/') . env('PATH_IMAGE') . $this->avatar;
    }


    public function calcu()
    {
        $c = $this->Reviews()->count();
        $x = 0;
        if ($c != 0) {
            $sum = ProductsReview::where("products_id", $this->id)->sum("star");
            $x = $sum / $c;
        }
        return $x;
    }

    public function price()
    {
        $select_curr = Currencies::where('select', '=', 1)->first();
        if (Cookie::get('currency') != null) {
            $curenc_cooki = Currencies::where('code', '=', Cookie::get('currency'))->first();
        } else {
            $curenc_cooki = Currencies::where('select', '=', 1)->first();
        }
        if ($curenc_cooki->code == $select_curr->code) {
            $price = $this->price . $select_curr->code;
        } else {
            $price = round($this->price * $curenc_cooki->CurrencyConversions->price, 2) . $curenc_cooki->code;
        }
        return "<span class=\"price\">$price</span>";
    }


    public function new_price()
    {
        if ($this->new_price != null) {
            $select_curr = Currencies::where('select', '=', 1)->first();
            if (Cookie::get('currency') != null) {
                $curenc_cooki = Currencies::where('code', '=', Cookie::get('currency'))->first();
            } else {
                $curenc_cooki = Currencies::where('select', '=', 1)->first();
            }
            if ($curenc_cooki->code == $select_curr->code) {
                $price_old = $this->price . $select_curr->code;
                $price = $this->new_price . $select_curr->code;
            } else {
                $price_old = round($this->price * $curenc_cooki->CurrencyConversions->price, 2) . ' ' . $curenc_cooki->code;
                $price = round($this->new_price * $curenc_cooki->CurrencyConversions->new_price, 2) . ' ' . $curenc_cooki->code;
            }
            return "<p class=\"ps-product__price\">
                                    <del>$price</del>
                                    - $price_old
                                </p>";
        } else {
            return $this->price();
        }
    }

    public function route()
    {
        return route('product', ['id' => $this->id, 'name' => $this->name]);
    }

    public function save_per()
    {
        $newone = $this->new_price;
        $old = $this->price;
        $sum = $newone / $old;
        $total = $sum * 100;
        return round($total, 2) . '%';
    }

    public function is_new($new_lang)
    {
        if ($this->new == 1) {
            return "<li class=\"flag-pack\">$new_lang</li>";
        } else {
            return "";
        }
    }

    public function stars()
    {
        $r = ProductsReview::where("products_id", $this->id)->first();
        if ($r == null) {
            return "";
        } else {
            $rs = "";
            for ($i = 0; $i < $r->star; $i++) {
                $rs = $rs . "<span class=\"active\"><i class=\"ion ion-ios-star\"></i></span>";
            }
            return $rs;
        }
    }

    public function rating_count()
    {
        $items = ProductsReview::where("products_id", $this->id)->count();
        return $items;
    }

    public function fav()
    {
        return redirect()->route('fav_add', ['id' => $this->id]);
    }

    public function rating()
    {
        $items = ProductsReview::where("products_id", $this->id)->count();
        $rs = "";
        if ($items != 0) {
            $sum = ProductsReview::where("products_id", $this->id)->sum("star");
            $total = round($sum / $items);
            $rs = "";
            for ($i = 0; $i < $total; $i++) {
                $rs = $rs . "<i class=\"fa fa-star\"></i>";
            }
            return $rs;
        } else {
            $rs = "<i class=\"fa fa-star\" ></i>";
        }
        return $rs;
    }

    public function Categories()
    {
        $category_1 = $this->category_1;
        $count_list_re = explode(",", $category_1);
        $ret = "";
        if (count($count_list_re) != 0) {
            foreach ($count_list_re as $key => $value) {
                if ($value) {
                    $toekn = csrf_token();
                    $item2 = Category::where("id", $value)->first();
                    if ($item2) {
                        $ret = "<a href=\"{$item2->route_products()}\">{$item2->name()}</a>," . $ret;
                    }
                }
            }
        }
        return $ret;
    }

    public function Related()
    {
        $related_products = $this->related_products;
        $count_list_re = explode(",", $related_products);
        $ret = "";
        if (count($count_list_re) != 0) {
            foreach ($count_list_re as $key => $value) {
                if ($value) {
                    $toekn = csrf_token();
                    $item2 = Products::where("id", $value)->first();
                    if ($item2) {
                        $ret = $ret . "<div class=\"news-block col-lg-6 col-md-6 col-sm-12 wow fadeInUp\" data-wow-delay=\"0ms\"
                                     data-wow-duration=\"1500ms\">
                                    <div class=\"inner-box\">
                                        <div class=\"image-box\">
                                            <a href=\"{$item2->route()}\"><img src=\"{$item2->img()}\" alt=\"{$item2->name()}\"></a>
                                            <div class=\"labels\">
                                                <span class=\"label-black\">{$item2->Category->name()}</span> 
                                            </div>
                                        </div>
                                        <div class=\"lower-box\">
                                            <div class=\"post-meta\">
                                                <ul class=\"clearfix\">
                                                    <li><span class=\"fas fa-ruler-combined\"></span>{$item2->sq}</li>
                                                    <li><span class=\"fas fa-car\"></span>{$item2->car}</li>
                                                    <li><span class=\"fas fa-shower\"></span>{$item2->bath_rooms}</li>
                                                </ul>
                                            </div>
                                            <h5><a href=\"{$item2->route()}\">" . $item2->sub_name() . "</a></h5>
                                            <div class=\"text\">" . $item2->sub_name() . "</div>
                                            <ul></ul>
                                            <div>
                                                <a class=\"theme-btn\" href=\"{$item2->route()}\">".lang_name('Read_More')."</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                    }
                }
            }
        }
        return $ret;
    }

    public function sizes()
    {
        $sizes = $this->sizes;
        $count_sizes = explode(",", $sizes);
        $x = "";
        if ($sizes != null) {
            if ($count_sizes != 0) {
                foreach ($count_sizes as $key => $value) {
                    if ($value) {
                        $x = $x . "<li><a href=\"#\">{$value}</a></li>";
                    }
                }
            }
        }
        return $x;
    }
    public function colors()
    {
        $colors = $this->colors;
        $count_color = explode(",", $colors);
        $x = "";
        if ($colors != null) {
            if ($count_color != 0) {
                foreach ($count_color as $key => $value) {
                    if ($value) {
                        $x = $x . "<a class=\"ps-color ps-color--1\" style=\"background: {$value}!important;\" href=\"#\"></a>";
                    }
                }
            }
        }
        return $x;
    }

    function share($type)
    {
        if ($type == "face") {
            $face = "https://www.facebook.com/sharer.php?u=" . $this->route();
            return $face;
        } else if ($type == "twitter") {
            $face = "https://twitter.com/share?url=" . $this->route();
            return $face;
        } else if ($type == "linkedin") {
            $face = "https://linkedin.com/share?url=" . $this->route();
            return $face;
        } else if ($type == "whatsapp") {
            $face = "whatsapp://send?text=" . $this->route();
            return $face;
        }
        return null;
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $table = "setting";

    public $fillable = ['id','name',
        'hours',
        'language_id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function SettingTranslate(){
        return $this->hasOne(SettingTranslate::class,"setting_id","id");
    }

    public function Translate($i){
        return $this->hasOne(SettingTranslate::class,"setting_id","id")
            ->where('language_id','=',$i)->first();
    }

    public function fav(){
        return url('/').env('PATH_IMAGE').$this->fav;
    }

    public function avatar(){
        return url('/').env('PATH_IMAGE').$this->avatar;
    }

    public function avatar1(){
        return url('/').env('PATH_IMAGE').$this->avatar1;
    }

    public function fact(){
        return url('/').env('PATH_IMAGE').$this->fact;
    }

    public function payment(){
        return 1;
    }

    public function bunner(){
        return url('/').env('PATH_IMAGE').$this->bunner;
    }

    public function select_lan(){
        $select_lan = Language::where('dir', '=', app()->getLocale())->first();
        if ($select_lan == null) {
            $select_lan = Language::where('select', '=', '1')->first();
        }
        return $select_lan;
    }

    public function select_lang(){
        return  $select_lan_choice = Language::where('select', '=', '1')->first();
    }

    public function name(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->name;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->name : "";
        }
    }

    public function summary(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->summary;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->summary : "";
        }
    }

    public function bunner1(){
        return  url('/').env('PATH_IMAGE').$this->bunner1;
    }

    public function contact(){
        return  url('/').env('PATH_IMAGE').$this->contact;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    public $table = "hp_contents";

    public $fillable = ['id',
        'created_at','updated_at'];

    public $dates = ['created_at','updated_at'];
    public $primaryKey = 'id';

    public function Language(){
        return $this->belongsTo(Language::class,"language_id","id");
    }

    public function ContentsLists(){
        return $this->hasMany(ContentsTranslate::class,"hp_contents_id","id");
    }

    public function Translate($i){
        return $this->hasOne(ContentsTranslate::class,"hp_contents_id","id")
            ->where('language_id','=',$i)->first();
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

    public function sub_name(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->sub_name;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->sub_name : "";
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

    public function summary3(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->summary3;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->summary3 : "";
        }
    }

    public function sub_summary(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->sub_summary;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->sub_summary : "";
        }
    }

    public function sub_summary2(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->sub_summary2;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->sub_summary2 : "";
        }
    }

    public function summary1(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->summary1;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->summary1 : "";
        }
    }

    public function link(){
        return $this->link;
    }

    public function img1(){
        return url('/').env('PATH_IMAGE').$this->avatar1;
    }

    public function img2(){
        return url('/').env('PATH_IMAGE').$this->avatar2;
    }

    public function img3(){
        return url('/').env('PATH_IMAGE').$this->avatar3;
    }

    public function img4(){
        return  url('/').env('PATH_IMAGE').$this->avatar4;
    }

    public function img5(){
        return  url('/').env('PATH_IMAGE').$this->avatar5;
    }
}

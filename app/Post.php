<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = "post";

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

    public function Posts(){
        return $this->hasMany(PostTranslate::class,"post_id","id");
    }

    public function Gallery(){
        return $this->hasMany(PostGallery::class,"post_id","id");
    }

    public function Post(){
        return $this->hasOne(PostTranslate::class,"post_id","id");
    }

    public function Translate($i){
        return $this->hasOne(PostTranslate::class,"post_id","id")
            ->where('language_id','=',$i)->first();
    }

    public function select_lang(){
        return $select_lan_choice = Language::where('select', '=', '1')->first();
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

    public function tags(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->tags;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->tags : "";
        }
    }

    public function tags_a($class){
        $array = explode("-",$this->tags);
        $re = "";
        foreach($array as $key => $value){
            $e = '<li><a href="/blog?tags='. $value .'" class="'. $class .'">'. $value .'</a></li>';
            $re = $re . $e;
        }
        return $re;
    }

    public function date(){
        return date_format($this->created_at,'d m,Y');
    }

    public function route(){
        return route('post',['id'=>$this->id,'name'=>$this->name]);
    }

    public function summary(){
        if(app()->getLocale() == $this->select_lang()->dir){
            return $this->summary;
        }
        else{
            return $this->Translate($this->select_lan()->id) != null ? $this->Translate($this->select_lan()->id)->summary : "";
        }
    }

    public function img(){
        return env('PATH_IMAGE').$this->avatar;
    }

    public function share($type){
        if($type == "face"){
            $face = "https://www.facebook.com/sharer.php?u=".$this->route();
            return $face;
        }
        else if($type == "twitter"){
            $face = "https://twitter.com/share?url=".$this->route();
            return $face;
        }
        else if($type == "linkedin"){
            $face = "https://linkedin.com/share?url=".$this->route();
            return $face;
        }
        else if($type == "whatsapp"){
            $face = "whatsapp://send?text=".$this->route();
            return $face;
        }
        return null;
    }
}

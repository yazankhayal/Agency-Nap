<?php

namespace App\Http\Controllers\Dashboard;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index(){
        return view('dashboard/setting.index');
    }

    public function get_data_by_id(Request $request){
        $items = Setting::first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $Setting = Setting::first();
        $validation = Validator::make($request->all(), $this->rules($Setting),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($Setting == null){
                DB::transaction(function()
                {
                    $Setting = new Setting();
                    $Setting->name = Input::get('name');
                    $Setting->summary = Input::get('summary');
                    $Setting->avatar = parent::upladImage(Input::file('avatar'),'setting');
                    $Setting->avatar1 = parent::upladImage(Input::file('avatar1'),'setting');
                    $Setting->bunner = parent::upladImage(Input::file('bunner'),'setting');
                    $Setting->bunner1 = parent::upladImage(Input::file('bunner1'),'setting');
                    $Setting->fav = parent::upladImage(Input::file('fav'),'setting');
                    $Setting->fact = parent::upladImage(Input::file('fact'),'fact');
                    $Setting->language_id = parent::GetIdLangEn()->id;

                    $Setting->save();
                    if( !$Setting )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $Setting = Setting::first();
                    $Setting->name = Input::get('name');
                    $Setting->summary = Input::get('summary');
                    if(Input::hasFile('avatar')){
                        //Remove Old
                        if($Setting->avatar != 'setting/no.png'){
                            if(file_exists(public_path($Setting->avatar))){
                                unlink(public_path($Setting->avatar));
                            }
                        }
                        //Save avatar
                        $Setting->avatar = parent::upladImage(Input::file('avatar'),'setting');
                    }
                    if(Input::hasFile('avatar1')){
                        //Remove Old
                        if($Setting->avatar1 != 'setting/no.png'){
                            if(file_exists(public_path($Setting->avatar1))){
                                unlink(public_path($Setting->avatar1));
                            }
                        }
                        //Save avatar1
                        $Setting->avatar1 = parent::upladImage(Input::file('avatar1'),'setting');
                    }
                    if(Input::hasFile('bunner')){
                        //Remove Old
                        if($Setting->bunner != 'setting/no.png'){
                            if(file_exists(public_path($Setting->bunner))){
                                unlink(public_path($Setting->bunner));
                            }
                        }
                        //Save bunner
                        $Setting->bunner = parent::upladImage(Input::file('bunner'),'setting');
                    }
                    if(Input::hasFile('fav')){
                        //Remove Old
                        if($Setting->fav != 'setting/no.png'){
                            if(file_exists(public_path($Setting->fav))){
                                unlink(public_path($Setting->fav));
                            }
                        }
                        //Save fav
                        $Setting->fav = parent::upladImage(Input::file('fav'),'setting');
                    }

                    if(Input::hasFile('bunner1')){
                        //Remove Old
                        if($Setting->bunner1 != 'setting/no.png'){
                            if(file_exists(public_path($Setting->bunner1))){
                                unlink(public_path($Setting->bunner1));
                            }
                        }
                        //Save bunner1
                        $Setting->bunner1 = parent::upladImage(Input::file('bunner1'),'bunner1');
                    }

                    if(Input::hasFile('fact')){
                        //Remove Old
                        if($Setting->fact != 'setting/no.png'){
                            if(file_exists(public_path($Setting->fact))){
                                unlink(public_path($Setting->fact));
                            }
                        }
                        //Save fact
                        $Setting->fact = parent::upladImage(Input::file('fact'),'fact');
                    }

                    $Setting->update();
                    if( !$Setting )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'same_page'=>'1','dashboard'=>'1']);
            }
        }
    }

    private function rules($edit = null,$pass = null){
        $x= [
            'name' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'avatar' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'summary' => 'required|string',
            'avatar1' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'payment' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'bunner' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'fav' => 'required|mimes:png,jpg,jpeg,ico,PNG,JPG,JPEG,ICO',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
            $x['avatar'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['bunner'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['fav'] ='nullable|mimes:png,jpg,jpeg,ico,PNG,JPG,JPEG,ICO';
            $x['avatar1'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['payment'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
        }
        return $x;
    }

    private function languags(){
        if(app()->getLocale() == "ar"){
            return [
                'keywords' => 'The keywords field is required.',
                'description ' => 'The description  field is required.',
                'name.required' => 'حقل الاسم مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'fav.required' => 'حقل العلامة في تاب الموقع مطلوب.',
                'avatar.required' => 'حقل الصورة في الهيدر مطلوب.',
                'avatar1.required' => 'حقل الصورة في الفوتير مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',

            ];
        }
        else{
            return [];
        }
    }

}

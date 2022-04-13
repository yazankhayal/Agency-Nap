<?php

namespace App\Http\Controllers\Dashboard;

use App\SettingTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SettingTranslateController extends Controller
{

    function get_data_by_id(Request $request){
        $id = $request->id;
        $language_id = $request->language_id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $SubScriptions = SettingTranslate::where('setting_id' ,'=',$id)
            ->where('language_id' ,'=',$language_id )->first();
        if($SubScriptions == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        return response()->json(['success'=>$SubScriptions]);
    }

    public function post_data(Request $request){
        $edit = $request->id;
        $password = $request->password;
        $validation = Validator::make($request->all(), $this->rules($edit),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            $check = SettingTranslate::
            where('id' ,'=',Input::get('id'))
                ->where('setting_id' ,'=',Input::get('setting_id'))
                ->where('language_id' ,'=',Input::get('language_id'))
                ->first();
            if($check != null){
                DB::transaction(function()
                {
                    $SettingTranslate = SettingTranslate::where('id' ,'=',Input::get('id'))->first();
                    $SettingTranslate->name = Input::get('name');
                    $SettingTranslate->summary = Input::get('summary');
                    $SettingTranslate->language_id = Input::get('language_id');
                    $SettingTranslate->setting_id = Input::get('setting_id');
                    $SettingTranslate->update();
                    if( !$SettingTranslate )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1','same_page'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $SettingTranslate = new SettingTranslate();
                    $SettingTranslate->name = Input::get('name');
                    $SettingTranslate->summary = Input::get('summary');
                    $SettingTranslate->language_id = Input::get('language_id');
                    $SettingTranslate->setting_id = Input::get('setting_id');
                    $SettingTranslate->update();
                    $SettingTranslate->save();
                    if( !$SettingTranslate )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'dashboard'=>'1','same_page'=>'1']);
            }
        }
    }

    private function rules($edit = null,$pass = null){
        $x= [
            'name' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'summary' => 'required|string',
            'setting_id' => 'required|numeric|min:1',
            'language_id' => 'required|numeric|min:1',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }
        return $x;
    }

    private function languags(){
        if(app()->getLocale() == "ar"){
            return [
                'name.required' => 'حقل الاسم مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',
                'avatar1.required' => 'حقل الصورة في الفوتير مطلوب.',
                'summary.required' => 'حقل الوصف مطلوب.',
                'language_id.required' => 'حقل الغة مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',

            ];
        }
        else{
            return [];
        }
    }


}

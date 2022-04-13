<?php

namespace App\Http\Controllers\Dashboard;

use App\CityTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CityTranslateController extends Controller
{
    function get_data_by_id(Request $request){
        $id = $request->id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $SubScriptions = CityTranslate::where('id' ,'=',$id)->first();
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
            if($edit != null){
                DB::transaction(function()
                {
                    $CityTranslate = CityTranslate::where('id' ,'=',Input::get('id'))->first();
                    $CityTranslate->name = Input::get('name');
                    $CityTranslate->language_id = Input::get('language_id');
                    $CityTranslate->city_id = Input::get('city_id');
                    $CityTranslate->update();
                    if( !$CityTranslate )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1']);
            }
            else{
                $check = CityTranslate::
                where('city_id' ,'=',Input::get('city_id'))
                    ->where('language_id' ,'=',Input::get('language_id'))
                    ->first();
                if($check != null){
                    return response()->json(['error'=> __('language.msg.already')]);
                }
                DB::transaction(function()
                {
                    $CityTranslate = new CityTranslate();
                    $CityTranslate->name = Input::get('name');
                    $CityTranslate->language_id = Input::get('language_id');
                    $CityTranslate->city_id = Input::get('city_id');
                    $CityTranslate->save();
                    if( !$CityTranslate )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'dashboard'=>'1']);
            }
        }
    }

    private function rules($edit = null,$pass = null){
        $x= [
            'name' => 'required|min:3|max:191',
            'city_id' => 'required|numeric|min:1',
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
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'summary.required' => 'حقل الوصف مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',

            ];
        }
        else{
            return [];
        }
    }


}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Contents;
use App\ContentsTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class WhyTranslateController extends Controller
{
    function get_data_by_id(Request $request){
        $id = $request->id;
        $language_id = $request->language_id;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $SubScriptions = ContentsTranslate::where('hp_contents_id' ,'=',$id)
            ->where('language_id' ,'=',$language_id )->first();
        if($SubScriptions == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        return response()->json(['success'=>$SubScriptions]);
    }

    public function post_data(Request $request){
        $edit = $request->id;
        $validation = Validator::make($request->all(), $this->rules($edit),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            $check = ContentsTranslate::
            where('id' ,'=',Input::get('id'))
                ->where('hp_contents_id' ,'=',Input::get('hp_contents_id'))
                ->where('language_id' ,'=',Input::get('language_id'))
                ->first();
            if($check != null){
                DB::transaction(function()
                {
                    $Contents = ContentsTranslate::where('id' ,'=',Input::get('id'))->first();
                    $Contents->summary = Input::get('summary');
                    $Contents->summary1 = Input::get('summary1');
                    $Contents->language_id = Input::get('language_id');
                    $Contents->hp_contents_id = Input::get('hp_contents_id');
                    $Contents->update();
                    if( !$Contents )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1','same_page'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $Contents = new ContentsTranslate();
                    $Contents->summary = Input::get('summary');
                    $Contents->summary1 = Input::get('summary1');
                    $Contents->language_id = Input::get('language_id');
                    $Contents->hp_contents_id = Input::get('hp_contents_id');
                    $Contents->update();
                    $Contents->save();
                    if( !$Contents )
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
            'hp_contents_id' => 'required|numeric|min:1',
            'summary' => 'required|string',
            'summary1' => 'required|string',
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
                'sub_name.required' => 'حقل الاسم الثانوي مطلوب.',
                'sub_name.regex' => 'حقل الاسم الثانوي غير صحيح .',
                'sub_name.min' => 'حقل الاسم الثانوي مطلوب على الاقل 3 حقول .',
                'sub_name.max' => 'حقل الاسم الثانوي مطلوب على الاكثر 191 حرف  .',
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

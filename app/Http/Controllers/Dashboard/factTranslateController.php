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

class factTranslateController extends Controller
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
                    $Contents->name = Input::get('name');
                    $Contents->sub_name = Input::get('sub_name');
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
                    $Contents->name = Input::get('name');
                    $Contents->sub_name = Input::get('sub_name');
                    $Contents->summary = Input::get('summary');
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
            'name' => 'required|string|max:191',
            'sub_name' => 'required|string|max:191',
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
                'name.required' => '?????? ?????????? ??????????.',
                'name.regex' => '?????? ?????????? ?????? ???????? .',
                'name.min' => '?????? ?????????? ?????????? ?????? ?????????? 3 ???????? .',
                'name.max' => '?????? ?????????? ?????????? ?????? ???????????? 191 ??????  .',
                'sub_name.required' => '?????? ?????????? ?????????????? ??????????.',
                'sub_name.regex' => '?????? ?????????? ?????????????? ?????? ???????? .',
                'sub_name.min' => '?????? ?????????? ?????????????? ?????????? ?????? ?????????? 3 ???????? .',
                'sub_name.max' => '?????? ?????????? ?????????????? ?????????? ?????? ???????????? 191 ??????  .',
                'summary.required' => '?????? ?????????? ??????????.',
                'language_id.required' => '?????? ???????? ??????????.',
                'dir.required' => '?????? ?????? ???????? ??????????.',
            ];
        }
        else{
            return [];
        }
    }


}

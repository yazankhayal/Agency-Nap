<?php

namespace App\Http\Controllers\Dashboard;

use App\ScriptsSetting;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ScriptsSettingController extends Controller
{
    public function index(){
        return view('dashboard/scripts.index');
    }

    public function get_data_by_id(Request $request){
        $items = ScriptsSetting::first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $Setting = ScriptsSetting::first();
        $validation = Validator::make($request->all(), $this->rules($Setting),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($Setting == null){
                DB::transaction(function()
                {
                    $Setting = new ScriptsSetting();
                    $Setting->js = Input::get('js');
                    $Setting->css = Input::get('css');
                    $Setting->custom = Input::get('custom');
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
                    $Setting = ScriptsSetting::first();
                    $Setting->js = Input::get('js');
                    $Setting->css = Input::get('css');
                    $Setting->custom = Input::get('custom');
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

    private function rules($edit = null){
        $x= [
            'css' => 'nullable|string',
            'js' => 'nullable|string',
            'custom' => 'nullable|string',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
        }
        return $x;
    }

    private function languags(){
        if(app()->getLocale() == "ar"){
            return [

            ];
        }
        else{
            return [];
        }
    }

}

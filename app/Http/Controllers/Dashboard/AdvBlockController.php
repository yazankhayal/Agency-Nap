<?php

namespace App\Http\Controllers\Dashboard;

use App\AdvBlock;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdvBlockController extends Controller
{
    public function index(){
        return view('dashboard/adv_block.index');
    }

    public function get_data_by_id(Request $request){
        $items = AdvBlock::first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $Setting = AdvBlock::first();
        $validation = Validator::make($request->all(), $this->rules($Setting),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($Setting == null){
                DB::transaction(function()
                {
                    $Setting = new AdvBlock();
                    $Setting->adv_blog_1 = Input::get('adv_blog_1');
                    $Setting->adv_blog_2 = Input::get('adv_blog_2');
                    $Setting->adv_blog_view_1 = Input::get('adv_blog_view_1');
                    $Setting->adv_blog_view_2 = Input::get('adv_blog_view_2');
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
                    $Setting = AdvBlock::first();
                    $Setting->adv_blog_1 = Input::get('adv_blog_1');
                    $Setting->adv_blog_2 = Input::get('adv_blog_2');
                    $Setting->adv_blog_view_1 = Input::get('adv_blog_view_1');
                    $Setting->adv_blog_view_2 = Input::get('adv_blog_view_2');
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
            'adv_blog_1' => 'nullable|string',
            'adv_blog_' => 'nullable|string',
            'adv_blog_view_1' => 'nullable|string',
            'adv_blog_view_2' => 'nullable|string',
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

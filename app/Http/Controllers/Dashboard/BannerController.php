<?php

namespace App\Http\Controllers\Dashboard;

use App\AdvBlock;
use App\Contents;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index(){
        return view('dashboard/banner.index');
    }

    public function get_data_by_id(Request $request){
        $items = Contents::where("type","banner")->first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $Setting = Contents::where("type","banner")->first();
        $validation = Validator::make($request->all(), $this->rules($Setting),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            $Setting = Contents::where("type","banner")->first();
            if($Setting == null){
                DB::transaction(function()
                {
                    $Setting = new Contents();
                    $Setting->type = "banner";
                    $Setting->name = Input::get('name');
                    $Setting->sub_name = Input::get('sub_name');
                    $Setting->summary = Input::get('summary');
                    $Setting->sub_summary = Input::get('sub_summary');
                    $Setting->summary1 = Input::get('summary1');
                    $Setting->avatar1 = parent::upladImage(Input::file('avatar1'),'banner','1');
                    $Setting->avatar2 = parent::upladImage(Input::file('avatar2'),'banner','2');
                    $Setting->avatar3 = parent::upladImage(Input::file('avatar3'),'banner','3');
                    $Setting->avatar4 = parent::upladImage(Input::file('avatar4'),'banner','4');
                    $Setting->avatar5 = parent::upladImage(Input::file('avatar5'),'banner','5');
                    $Setting->language_id = parent::GetIdLangEn()->id;
                    $Setting->user_id = parent::CurrentID();
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
                    $Setting = Contents::where("type","banner")->first();
                    $Setting->name = Input::get('name');
                    $Setting->sub_name = Input::get('sub_name');
                    $Setting->summary = Input::get('summary');
                    $Setting->sub_summary = Input::get('sub_summary');
                    $Setting->summary1 = Input::get('summary1');
                    if(Input::hasFile('avatar1')){
                        //Remove Old
                        if($Setting->avatar1 != 'upload/banner/no.png'){
                            if(file_exists(public_path($Setting->avatar1))){
                                unlink(public_path($Setting->avatar1));
                            }
                        }
                        //Save avatar1
                        $Setting->avatar1 = parent::upladImage(Input::file('avatar1'),'banner','1');
                    }

                    if(Input::hasFile('avatar2')){
                        //Remove Old
                        if($Setting->avatar2 != 'upload/banner/no.png'){
                            if(file_exists(public_path($Setting->avatar2))){
                                unlink(public_path($Setting->avatar2));
                            }
                        }
                        //Save avatar1
                        $Setting->avatar2 = parent::upladImage(Input::file('avatar2'),'banner','2');
                    }

                    if(Input::hasFile('avatar3')){
                        //Remove Old
                        if($Setting->avatar3 != 'upload/banner/no.png'){
                            if(file_exists(public_path($Setting->avatar3))){
                                unlink(public_path($Setting->avatar3));
                            }
                        }
                        //Save avatar1
                        $Setting->avatar3 = parent::upladImage(Input::file('avatar3'),'banner','3');
                    }

                    if(Input::hasFile('avatar4')){
                        //Remove Old
                        if($Setting->avatar4 != 'upload/banner/no.png'){
                            if(file_exists(public_path($Setting->avatar4))){
                                unlink(public_path($Setting->avatar4));
                            }
                        }
                        //Save avatar1
                        $Setting->avatar4 = parent::upladImage(Input::file('avatar4'),'banner','4');
                    }


                    if(Input::hasFile('avatar5')){
                        //Remove Old
                        if($Setting->avatar5 != 'upload/banner/no.png'){
                            if(file_exists(public_path($Setting->avatar5))){
                                unlink(public_path($Setting->avatar5));
                            }
                        }
                        //Save avatar1
                        $Setting->avatar5 = parent::upladImage(Input::file('avatar5'),'banner','5');
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

    private function rules($edit = null){
        $x= [
            'avatar1' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'avatar2' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'avatar3' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'avatar4' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'avatar5' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
            $x['avatar1'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar2'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar3'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar4'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar5'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
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

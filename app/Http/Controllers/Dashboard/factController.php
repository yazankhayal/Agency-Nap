<?php

namespace App\Http\Controllers\Dashboard;

use App\Contents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class factController extends Controller
{
    public function index(){
        return view('dashboard/fact.index');
    }

    public function get_data_by_id(Request $request){
        $items = Contents::where('type','=','fact')->first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $fact = Contents::where('type','=','fact')->first();
        $validation = Validator::make($request->all(), $this->rules($fact),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($fact == null){
                DB::transaction(function()
                {
                    $fact = new Contents();
                    $fact->type = 'fact';
                    $fact->name = Input::get('name');
                    $fact->sub_name = Input::get('sub_name');
                    $fact->summary = Input::get('summary');
                    $fact->avatar1 = parent::upladImage(Input::file('avatar1'),'fact');
                    $fact->language_id = parent::GetIdLangEn()->id;
                    $fact->user_id = parent::CurrentID();
                    $fact->save();
                    if( !$fact )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $fact = Contents::where('type','=','fact')->first();
                    $fact->name = Input::get('name');
                    $fact->sub_name = Input::get('sub_name');
                    $fact->summary = Input::get('summary');
                    if(Input::hasFile('avatar1')){
                        //Remove Old
                        if($fact->avatar1 != 'upload/fact/no.png'){
                            if(file_exists(public_path($fact->avatar1))){
                                unlink(public_path($fact->avatar1));
                            }
                        }
                        //Save avatar1
                        $fact->avatar1 = parent::upladImage(Input::file('avatar1'),'fact');
                    }
                    $fact->update();
                    if( !$fact )
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
            'name' => 'required|string|max:191',
            'sub_name' => 'required|string|max:191',
            'summary' => 'required|string',
            'avatar1' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
            $x['avatar1'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
        }
        return $x;
    }

    private function languags(){
        if(app()->getLocale() == "ar"){
            return [
                'link.required' => 'حقل الرابط مطلوب.',
                'video.required' => 'حقل الفيديو مطلوب.',
                'link.required' => 'حقل الوصف مطلوب.',
                'name.required' => 'حقل الاسم مطلوب.',
                'name.regex' => 'حقل الاسم غير صحيح .',
                'name.min' => 'حقل الاسم مطلوب على الاقل 3 حقول .',
                'name.max' => 'حقل الاسم مطلوب على الاكثر 191 حرف  .',
                'sub_name.required' => 'حقل الاسم الثانوي مطلوب.',
                'sub_name.regex' => 'حقل الاسم الثانوي غير صحيح .',
                'sub_name.min' => 'حقل الاسم الثانوي مطلوب على الاقل 3 حقول .',
                'sub_name.max' => 'حقل الاسم الثانوي مطلوب على الاكثر 191 حرف  .',
                'avatar1.required' => 'حقل الصورة الاولى مطلوب.',
                'avatar2.required' => 'حقل الصورة الثانية مطلوب.',
                'avatar3.required' => 'حقل الصورة الثالثة مطلوب.',
                'avatar4.required' => 'حقل الصورة الرابعة مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',
            ];
        }
        else{
            return [];
        }
    }

}

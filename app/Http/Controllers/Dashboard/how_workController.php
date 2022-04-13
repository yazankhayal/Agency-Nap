<?php

namespace App\Http\Controllers\Dashboard;

use App\Contents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class how_workController extends Controller
{
    public function index(){
        return view('dashboard/how_work.index');
    }

    public function get_data_by_id(Request $request){
        $items = Contents::where('type','=','how_work')->first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $how_work = Contents::where('type','=','how_work')->first();
        $validation = Validator::make($request->all(), $this->rules($how_work),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($how_work == null){
                DB::transaction(function()
                {
                    $how_work = new Contents();
                    $how_work->type = 'how_work';
                    $how_work->name = Input::get('name');
                    $how_work->link = Input::get('link');
                    $how_work->video = Input::get('video');
                    $how_work->summary = Input::get('summary');
                    $how_work->language_id = parent::GetIdLangEn()->id;
                    $how_work->user_id = parent::CurrentID();
                    $how_work->avatar1 = parent::upladImage(Input::file('avatar'), 'how_work');
                    $how_work->save();
                    if( !$how_work )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $how_work = Contents::where('type','=','how_work')->first();
                    $how_work->name = Input::get('name');
                    $how_work->link = Input::get('link');
                    $how_work->video = Input::get('video');
                    $how_work->summary = Input::get('summary');
                    if(Input::get('avatar')){
                        $how_work->avatar1 = parent::upladImage(Input::file('avatar'), 'how_work');
                    }
                    $how_work->update();
                    if( !$how_work )
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
            'link' => 'required|string|max:191',
            'video' => 'required|string|max:191',
            'summary' => 'required|string',
            'avatar' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
            $x['avatar'] = 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
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

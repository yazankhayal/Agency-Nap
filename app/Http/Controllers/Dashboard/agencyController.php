<?php

namespace App\Http\Controllers\Dashboard;

use App\Contents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class agencyController extends Controller
{
    public function index(){
        return view('dashboard/agency.index');
    }

    public function get_data_by_id(Request $request){
        $items = Contents::where('type','=','agency')->first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $agency = Contents::where('type','=','agency')->first();
        $validation = Validator::make($request->all(), $this->rules($agency),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($agency == null){
                DB::transaction(function()
                {
                    $agency = new Contents();
                    $agency->type = 'agency';
                    $agency->name = Input::get('name');
                    $agency->sub_name = Input::get('sub_name');
                    $agency->summary = Input::get('summary');
                    $agency->sub_summary = Input::get('sub_summary');
                    $agency->summary1 = Input::get('summary1');
                    $agency->sub_summary2 = Input::get('sub_summary2');
                    $agency->summary3 = Input::get('summary3');
                    $agency->avatar1 = parent::upladImage(Input::file('avatar1'),'agency');
                    $agency->language_id = parent::GetIdLangEn()->id;
                    $agency->user_id = parent::CurrentID();
                    $agency->save();
                    if( !$agency )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $agency = Contents::where('type','=','agency')->first();
                    $agency->name = Input::get('name');
                    $agency->sub_name = Input::get('sub_name');
                    $agency->summary = Input::get('summary');
                    $agency->sub_summary = Input::get('sub_summary');
                    $agency->summary1 = Input::get('summary1');
                    $agency->sub_summary2 = Input::get('sub_summary2');
                    $agency->summary3 = Input::get('summary3');
                    if(Input::hasFile('avatar1')){
                        //Remove Old
                        if($agency->avatar1 != 'upload/agency/no.png'){
                            if(file_exists(public_path($agency->avatar1))){
                                unlink(public_path($agency->avatar1));
                            }
                        }
                        //Save avatar1
                        $agency->avatar1 = parent::upladImage(Input::file('avatar1'),'agency');
                    }
                    $agency->update();
                    if( !$agency )
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
            'summary3' => 'required|string',
            'summary1' => 'required|string',
            'sub_summary' => 'required|string',
            'sub_summary2' => 'required|string',
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

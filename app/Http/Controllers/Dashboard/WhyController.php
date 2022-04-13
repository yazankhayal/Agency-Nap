<?php

namespace App\Http\Controllers\Dashboard;

use App\Contents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class WhyController extends Controller
{
    public function index(){
        return view('dashboard/why.index');
    }

    public function get_data_by_id(Request $request){
        $items = Contents::where('type','=','why')->first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $why = Contents::where('type','=','why')->first();
        $validation = Validator::make($request->all(), $this->rules($why),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($why == null){
                DB::transaction(function()
                {
                    $why = new Contents();
                    $why->type = 'why';
                    $why->summary = Input::get('summary');
                    $why->summary1 = Input::get('summary1');
                    $why->avatar1 = parent::upladImage(Input::file('avatar1'),'why','1');
                    $why->avatar2 = parent::upladImage(Input::file('avatar2'),'why','2');
                    $why->avatar3 = parent::upladImage(Input::file('avatar3'),'why','3');
                    $why->language_id = parent::GetIdLangEn()->id;
                    $why->user_id = parent::CurrentID();
                    $why->save();
                    if( !$why )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=> __('language.msg.s'),'same_page'=>'1','dashboard'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $why = Contents::where('type','=','why')->first();
                    $why->summary = Input::get('summary');
                    $why->summary1 = Input::get('summary1');
                    if(Input::hasFile('avatar1')){
                        //Remove Old
                        if($why->avatar1 != 'upload/why/no.png'){
                            if(file_exists(public_path($why->avatar1))){
                                unlink(public_path($why->avatar1));
                            }
                        }
                        //Save avatar1
                        $why->avatar1 = parent::upladImage(Input::file('avatar1'),'why','1');
                    }


                    if(Input::hasFile('avatar2')){
                        //Remove Old
                        if($why->avatar2 != 'upload/why/no.png'){
                            if(file_exists(public_path($why->avatar2))){
                                unlink(public_path($why->avatar2));
                            }
                        }
                        //Save avatar2
                        $why->avatar2 = parent::upladImage(Input::file('avatar2'),'why','2');
                    }


                    if(Input::hasFile('avatar3')){
                        //Remove Old
                        if($why->avatar3 != 'upload/why/no.png'){
                            if(file_exists(public_path($why->avatar3))){
                                unlink(public_path($why->avatar3));
                            }
                        }
                        //Save avatar3
                        $why->avatar3 = parent::upladImage(Input::file('avatar3'),'why','3');
                    }
                    $why->update();
                    if( !$why )
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
            'summary' => 'required|string',
            'summary1' => 'required|string',
            'avatar1' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'avatar2' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'avatar3' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
        ];
        if($edit != null){
            $x['id'] ='required|integer|min:1';
            $x['avatar1'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar2'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
            $x['avatar3'] ='nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG';
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

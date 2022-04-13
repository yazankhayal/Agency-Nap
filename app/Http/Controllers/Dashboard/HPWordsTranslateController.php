<?php

namespace App\Http\Controllers\Dashboard;

use App\HPWordsTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HPWordsTranslateController extends Controller
{

    function get_data_by_id(Request $request){
        $id = $request->id_translate;
        if($id == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        $SubScriptions = HPWordsTranslate::where('language_id' ,'=',$id)->first();
        if($SubScriptions == null){
            return response()->json(['error'=> __('language.msg.e')]);
        }
        return response()->json(['success'=>$SubScriptions]);
    }

    public function post_data(Request $request){
        $edit = $request->id_translate;
        $validation = Validator::make($request->all(), $this->rules($edit),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($edit != null){
                DB::transaction(function()
                {
                    $HPWordsTranslate = HPWordsTranslate::where('id' ,'=',Input::get('id_translate'))->first();
                    $HPWordsTranslate->home = Input::get('home');
                    $HPWordsTranslate->about = Input::get('about');
                    $HPWordsTranslate->services = Input::get('services');
                    $HPWordsTranslate->blog = Input::get('blog');
                    $HPWordsTranslate->contact = Input::get('contact');
                    $HPWordsTranslate->shop = Input::get('shop');
                    $HPWordsTranslate->shop_sub_name = Input::get('shop_sub_name');
                    $HPWordsTranslate->testimonials = Input::get('testimonials');
                    $HPWordsTranslate->products = Input::get('products');
                    $HPWordsTranslate->contact_us = Input::get('contact_us');
                    $HPWordsTranslate->contact_us_sub_name = Input::get('contact_us_sub_name');
                    $HPWordsTranslate->contact_us_address = Input::get('contact_us_address');
                    $HPWordsTranslate->contact_us_working = Input::get('contact_us_working');
                    $HPWordsTranslate->contact_us_social = Input::get('contact_us_social');
                    $HPWordsTranslate->language_id = Input::get('language_id');
                    $HPWordsTranslate->hp_words_id = Input::get('hp_words_id');
                    $HPWordsTranslate->newsletter = Input::get('newsletter');
                    $HPWordsTranslate->newsletter_sub = Input::get('newsletter_sub');
                    $HPWordsTranslate->location = Input::get('location');
                    $HPWordsTranslate->location_sub = Input::get('location_sub');
                    $HPWordsTranslate->f_1 = Input::get('f_1');
                    $HPWordsTranslate->f_2 = Input::get('f_2');
                    $HPWordsTranslate->f_3 = Input::get('f_3');
                    $HPWordsTranslate->update();
                    if( !$HPWordsTranslate )
                    {
                        return response()->json(['error'=> __('language.msg.e')]);
                    }
                });
                return response()->json(['success'=>__('language.msg.m'),'dashboard'=>'1','same_page'=>'1']);
            }
            else{
                DB::transaction(function()
                {
                    $HPWordsTranslate = new HPWordsTranslate();
                    $HPWordsTranslate->home = Input::get('home');
                    $HPWordsTranslate->about = Input::get('about');
                    $HPWordsTranslate->services = Input::get('services');
                    $HPWordsTranslate->blog = Input::get('blog');
                    $HPWordsTranslate->contact = Input::get('contact');
                    $HPWordsTranslate->products = Input::get('products');
                    $HPWordsTranslate->shop = Input::get('shop');
                    $HPWordsTranslate->shop_sub_name = Input::get('shop_sub_name');
                    $HPWordsTranslate->testimonials = Input::get('testimonials');
                    $HPWordsTranslate->contact_us = Input::get('contact_us');
                    $HPWordsTranslate->contact_us_sub_name = Input::get('contact_us_sub_name');
                    $HPWordsTranslate->contact_us_address = Input::get('contact_us_address');
                    $HPWordsTranslate->contact_us_working = Input::get('contact_us_working');
                    $HPWordsTranslate->contact_us_social = Input::get('contact_us_social');
                    $HPWordsTranslate->language_id = Input::get('language_id');
                    $HPWordsTranslate->hp_words_id = Input::get('hp_words_id');
                    $HPWordsTranslate->newsletter = Input::get('newsletter');
                    $HPWordsTranslate->newsletter_sub = Input::get('newsletter_sub');
                    $HPWordsTranslate->location = Input::get('location');
                    $HPWordsTranslate->location_sub = Input::get('location_sub');
                    $HPWordsTranslate->f_1 = Input::get('f_1');
                    $HPWordsTranslate->f_2 = Input::get('f_2');
                    $HPWordsTranslate->f_3 = Input::get('f_3');
                    $HPWordsTranslate->save();
                    if( !$HPWordsTranslate )
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
            'home' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'about' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'services' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'blog' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'contact' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'shop' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'shop_sub_name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'testimonials' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'contact_us' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'contact_us_sub_name' => 'required|min:3|max:191|regex:/^[ا-يa-zA-Z0-9]/',
            'contact_us_address' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'contact_us_working' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'contact_us_social' => 'required|min:3|regex:/^[ا-يa-zA-Z0-9]/',
            'hp_words_id' => 'required|numeric|min:1',
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
                'home.required' => 'حقل الرئيسية مطلوب.',
                'home.regex' => 'حقل الرئيسية غير صحيح .',
                'home.min' => 'حقل الرئيسية مطلوب على الاقل 3 حقول .',
                'about.required' => 'حقل من نحن مطلوب.',
                'about.regex' => 'حقل من نحن غير صحيح .',
                'about.min' => 'حقل من نحن مطلوب على الاقل 3 حقول .',
                'products.required' => 'حقل المنتجات مطلوب.',
                'products.regex' => 'حقل المنتجات غير صحيح .',
                'products.min' => 'حقل المنتجات مطلوب على الاقل 3 حقول .',
                'services.required' => 'حقل الخدمات مطلوب.',
                'services.regex' => 'حقل الخدمات غير صحيح .',
                'services.min' => 'حقل الخدمات مطلوب على الاقل 3 حقول .',
                'blog.required' => 'حقل المدونة مطلوب.',
                'blog.regex' => 'حقل المدونة غير صحيح .',
                'blog.min' => 'حقل المدونة مطلوب على الاقل 3 حقول .',
                'contact.required' => 'حقل تواصل معنا مطلوب.',
                'contact.regex' => 'حقل تواصل معنا غير صحيح .',
                'contact.min' => 'حقل تواصل معنا مطلوب على الاقل 3 حقول .',
                'shop.required' => 'حقل المتجات مطلوب.',
                'shop.regex' => 'حقل المتجات غير صحيح .',
                'shop.min' => 'حقل المتجات مطلوب على الاقل 3 حقول .',
                'shop_sub_name.required' => 'حقل وصف عن المتجات مطلوب.',
                'shop_sub_name.regex' => 'حقل وصف عن المتجات غير صحيح .',
                'shop_sub_name.min' => 'حقل وصف عن المتجات مطلوب على الاقل 3 حقول .',
                'shop_sub_name.max' => 'حقل وصف مطلوب على الاكثر 191 حرف  .',
                'testimonials.required' => 'حقل التوصيات مطلوب.',
                'testimonials.regex' => 'حقل التوصيات غير صحيح .',
                'testimonials.min' => 'حقل التوصيات مطلوب على الاقل 3 حقول .',
                'contact_us.required' => 'حقل نواصل معنا مطلوب.',
                'contact_us.regex' => 'حقل نواصل معنا غير صحيح .',
                'contact_us.min' => 'حقل نواصل معنا مطلوب على الاقل 3 حقول .',
                'contact_us_sub_name.required' => 'حقل وصف عن نواصل معنا مطلوب.',
                'contact_us_sub_name.regex' => 'حقل وصف عن نواصل معنا غير صحيح .',
                'contact_us_sub_name.min' => 'حقل وصف عن نواصل معنا مطلوب على الاقل 3 حقول .',
                'contact_us_sub_name.max' => 'حقل وصف عن نواصل معنا مطلوب على الاكثر 191 حرف  .',
                'contact_us_address.required' => 'حقل العنوان مطلوب.',
                'contact_us_address.regex' => 'حقل العنوان غير صحيح .',
                'contact_us_address.min' => 'حقل العنوان مطلوب على الاقل 3 حقول .',
                'contact_us_working.required' => 'حقل عدد ساعات العمل مطلوب.',
                'contact_us_working.regex' => 'حقل عدد ساعات العمل غير صحيح .',
                'contact_us_working.min' => 'حقل عدد ساعات العمل مطلوب على الاقل 3 حقول .',
                'contact_us_social.required' => 'حقل روابط التواصل الاجتماعي مطلوب.',
                'contact_us_social.regex' => 'حقل روابط التواصل الاجتماعي غير صحيح .',
                'contact_us_social.min' => 'حقل روابط التواصل الاجتماعي مطلوب على الاقل 3 حقول .',

                'language_id.required' => 'حقل الغة مطلوب.',
                'dir.required' => 'حقل كود الغة مطلوب.',

            ];
        }
        else{
            return [];
        }
    }


}

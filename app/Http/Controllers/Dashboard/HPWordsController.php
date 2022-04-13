<?php

namespace App\Http\Controllers\Dashboard;

use App\HPWords;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HPWordsController extends Controller
{
    public function index(){
        return view('dashboard/hp_words.index');
    }

    public function get_data_by_id(Request $request){
        $items = HPWords::first();
        return response()->json(['success'=>$items]);
    }

    public function post_data(Request $request){
        $Setting = HPWords::first();
        $validation = Validator::make($request->all(), $this->rules($Setting),$this->languags());
        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }
        else{
            if($Setting == null){
                DB::transaction(function()
                {
                    $Setting = new HPWords();
                    $Setting->home = Input::get('home');
                    $Setting->about = Input::get('about');
                    $Setting->services = Input::get('services');
                    $Setting->blog = Input::get('blog');
                    $Setting->products = Input::get('products');
                    $Setting->contact = Input::get('contact');
                    $Setting->shop = Input::get('shop');
                    $Setting->shop_sub_name = Input::get('shop_sub_name');
                    $Setting->testimonials = Input::get('testimonials');
                    $Setting->contact_us = Input::get('contact_us');
                    $Setting->contact_us_sub_name = Input::get('contact_us_sub_name');
                    $Setting->contact_us_address = Input::get('contact_us_address');
                    $Setting->contact_us_working = Input::get('contact_us_working');
                    $Setting->contact_us_social = Input::get('contact_us_social');
                    $Setting->newsletter = Input::get('newsletter');
                    $Setting->newsletter_sub = Input::get('newsletter_sub');
                    $Setting->location = Input::get('location');
                    $Setting->location_sub = Input::get('location_sub');
                    $Setting->f_1 = Input::get('f_1');
                    $Setting->f_2 = Input::get('f_2');
                    $Setting->f_3 = Input::get('f_3');
                    $Setting->language_id = parent::GetIdLangEn()->id;
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
                    $Setting = HPWords::first();
                    $Setting->home = Input::get('home');
                    $Setting->about = Input::get('about');
                    $Setting->services = Input::get('services');
                    $Setting->products = Input::get('products');
                    $Setting->blog = Input::get('blog');
                    $Setting->contact = Input::get('contact');
                    $Setting->shop = Input::get('shop');
                    $Setting->shop_sub_name = Input::get('shop_sub_name');
                    $Setting->testimonials = Input::get('testimonials');
                    $Setting->contact_us = Input::get('contact_us');
                    $Setting->contact_us_sub_name = Input::get('contact_us_sub_name');
                    $Setting->contact_us_address = Input::get('contact_us_address');
                    $Setting->contact_us_working = Input::get('contact_us_working');
                    $Setting->contact_us_social = Input::get('contact_us_social');
                    $Setting->newsletter = Input::get('newsletter');
                    $Setting->newsletter_sub = Input::get('newsletter_sub');
                    $Setting->location = Input::get('location');
                    $Setting->location_sub = Input::get('location_sub');
                    $Setting->f_1 = Input::get('f_1');
                    $Setting->f_2 = Input::get('f_2');
                    $Setting->f_3 = Input::get('f_3');
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
            ];
        }
        else{
            return [];
        }
    }

}
